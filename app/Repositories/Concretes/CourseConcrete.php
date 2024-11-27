<?php

namespace App\Repositories\Concretes;

use App\Models\Course;
use App\Models\Favorite;
use App\Models\Video;
use App\Repositories\Contracts\CourseContract;
use App\Traits\ApiResponseTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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

    public function create(array $attributes = []): mixed
    {
        DB::beginTransaction();

        try {

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
                    $record->videos()->create([
                        'name' => $video['name'],
                        'youtube_link' => $video['youtube_link'],
                        'publish_date' => $record->publish_date,
                        'videoable_type' => Course::class,
                        'videoable_id' => $record->id,
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
        $userId = auth()->id();

        $existingFavorite = Favorite::where('favoriteable_type', Course::class)
            ->where('favoriteable_id', $id)
            ->where('user_id', $userId)
            ->first();

        if ($existingFavorite) {
            $existingFavorite->delete();
            return $this->respondWithSuccess(__('Course removed from favorites'));
        } else {
            Favorite::create([
                'user_id' => $userId,
                'favoriteable_id' => $id,
                'favoriteable_type' => Course::class,
            ]);
            return $this->respondWithSuccess(__('Course added to favorites'));
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

}
