<?php

namespace App\Repositories\Concretes;

use App\Models\Course;

use App\Models\User;
use App\Repositories\Contracts\CourseContract;
use App\Traits\ApiResponseTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CourseConcrete extends BaseConcrete implements CourseContract
{
    use ApiResponseTrait;
    /**
     * AdminConcrete constructor.
     * @param Course $model
     */

    public function __construct(Course $model)
    {
        parent::__construct($model);
    }

    public function getLivewireCourses()
    {
        return Course::with(['category'])->get();
    }

    public function getLivewireCourseVideos(Course $model)
    {
        return $model->videos()->get();

    }

    public function create(array $attributes = []): mixed
    {
        DB::beginTransaction();

        try {

            $lastOrderPosition = Course::max('order_position');
            $nextOrderPosition = $lastOrderPosition + 1;

            // Include the next order position in the attributes
            $attributes['order_position'] = $nextOrderPosition;

         // create course
        $record = parent::create($attributes);

        // store course image
        if (isset($attributes['image']) && $attributes['image']->isValid()) {
            uploadImage('image', $attributes['image'], $record);
        }

        // Store videos if isset
        if (isset($attributes['videos'])) {
            foreach ($attributes['videos'] as $video) {
                if ($video) {
                    $lastVideoOrder = $record->videos()->max('order_position') ?? 0; // Get the last video's order

                    $record->videos()->create([
                        'name' => $video['name'],
                        'youtube_link' => $video['youtube_link'],
                        'publish_date' => $record->publish_date,
                        'videoable_type' => Course::class,
                        'videoable_id' => $record->id,
                        'order_position' => $lastVideoOrder + 1,
                    ]);
                }
            }
        }
            // Store attachments if isset

            $this->handleMedia($record, $attributes);

        DB::commit();

        return $record;
        }
        catch (\Exception $e) {
            DB::rollback();
           return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    private function handleMedia($record, $attributes): void
    {
        if (isset($attributes['attachments'])) {
            foreach ($attributes['attachments'] as $media) {
                if (in_array($media->extension(), ['pdf'])) {
                    uploadMedia('attachments', $media, $record, false);
                }
            }
        }
    }


    public function update(Model $model, array $attributes = []): mixed
    {
        DB::beginTransaction();

        try {
            // Update main course attributes

            $record = parent::update($model, $attributes);

           // Update course image
            if (isset($attributes['image']) && $attributes['image']->isValid()) {
                uploadImage('image', $attributes['image'], $record);
            }

        // Update videos
        if (isset($attributes['videos'])) {
            $existingVideos = $record->videos->keyBy('id');
            foreach ($attributes['videos'] as $video) {
                if (isset($video['id']) && $existingVideos->has($video['id'])) {
                    // Update existing video
                    $existingVideos->get($video['id'])->update([
                        'name' => $video['name'],
                        'youtube_link' => $video['youtube_link'],
                        'publish_date' => $record->publish_date,
                    ]);
                    $existingVideos->forget($video['id']);
                } else {
                    // Create new video
                    $record->videos()->create([
                        'name' => $video['name'],
                        'youtube_link' => $video['youtube_link'],
                        'publish_date' => $record->publish_date,
                    ]);
                }
            }

            // Delete removed videos
            foreach ($existingVideos as $remainingVideo) {
                $remainingVideo->delete();
            }
        }
            // update attachments
            $this->handleMedia($record, $attributes);

            DB::commit();

            return $record;
       } catch (\Exception $e) {
            DB::rollback();
           return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }



    // add comment to course
    public function addComment($courseId, array $attributes = [])
    {
        try {
            $course = Course::whereId($courseId)->Active()->ActiveCategory()->first();

            if (!$course) {
                throw new \Exception('Course not found or inactive.');
            }

            $attributes['user_id'] = auth()->id();
            $attributes['commentable_id'] = $course->id;
            $attributes['commentable_type'] = Course::class;

            $comment = $course->comments()->create($attributes);

            return $comment;
        } catch (\Exception $e) {
            throw $e; // Re-throw the exception for the controller to handle
        }
    }

    public function suggestedCourses()
    {
        $randomCourses = Course::with('media')
            ->ActiveCategory()->Active()->Publish()->inRandomOrder()->paginate(3);

        return $randomCourses;

    }


    public function toggleFavorite($id)
    {
        $course = Course::findOrFail($id);
        $userId = auth(activeGuard())?->user()->id;
        $existingFavorite =  $course->favorites()->where('user_id', $userId)->first();
        if ($existingFavorite) {
            $existingFavorite->delete();
            return $this->respondWithSuccess(__('Course removed from favorites'), ['is_favorite' => false]);
        } else {

         $course->favorites()->create([
                'user_id' => auth()->id(),
            ]);
            return $this->respondWithSuccess(__('Course added to favorites'), ['is_favorite' => true]);
        }

    }

    public function addSubscription($courseId)
    {

        $user = auth()->user();
        $course = Course::findOrFail($courseId);
        $subscription = $course->subscriptions()->where('user_id', $user->id)->first();
        if ($subscription) {
            $subscription->delete();
            return $this->respondWithSuccess(__('Course unsubscribed successfully'));
        } else {
            $data = [
                'user_id' => $user->id,
                'course_id' => $course->id,
            ];
             $course->subscriptions()->create($data);
            return $this->respondWithSuccess(__('Course subscribed successfully'));
        }
    }


    public function getFavorites()
    {
        $user = auth(activeGuard())?->user();
        if (!$user) {
            return response()->json(['message' => __('User not found')], 404);
        }
        $favoriteCourses = $user->favoriteCourses;
        return $favoriteCourses;

    }

    public function getMySubscriptions()
    {
        $user = auth(activeGuard())?->user();
        if (!$user) {
            return response()->json(['message' => __('User not found')], 404);
        }
        $courses = $user->subscriptions()->with('course')->get()->pluck('course');
        // Manually paginate the filtered courses
        $perPage = 10; // Adjust the per-page value as needed
        $currentPage = request('page', 1); // Default to the first page
        $paginatedCourses = new \Illuminate\Pagination\LengthAwarePaginator(
            $courses->forPage($currentPage, $perPage),
            $courses->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return $paginatedCourses;

    }

}
