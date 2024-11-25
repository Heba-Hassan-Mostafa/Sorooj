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


//    public function update(Model $model, array $attributes = []): mixed
//    {
//        DB::beginTransaction();
//
//        try {
//            // Update main course attributes
//        $record = parent::update($model, $attributes);
//
//            // Update course image
//            if (isset($attributes['image']) && $attributes['image']->isValid()) {
//                uploadImage('image', $attributes['image'], $record);
//            }
//
//            // Update or add new videos if provided
//            if (isset($attributes['videos'])) {
//                foreach ($attributes['videos'] as $video) {
//                    if (isset($video['id'])) {
//                        // Update existing video
//                        $record->videos()->where('id', $video['id'])->update([
//                            'name' => $video['name'],
//                            'youtube_link' => $video['youtube_link'],
//                            'publish_date' => $record->publish_date,
//                        ]);
//                    } else {
//                        // Add new video
//                        $record->videos()->create([
//                            'name' => $video['name'],
//                            'youtube_link' => $video['youtube_link'],
//                            'publish_date' => $record->publish_date,
//                            'videoable_type' => Courses::class,
//                            'videoable_id' => $record->id,
//                        ]);
//                    }
//                }
//            }
//            // Update or add new attachments if provided
//            if (isset($attributes['attachments'])) {
//                foreach ($attributes['attachments'] as $attachment) {
//                    if ($attachment->isValid()) {
//                        // Add new attachment (overwrite any existing attachments in the same collection)
//                        uploadImage('attachments', $attachment, $record);
//                    }
//                }
//            }
//
//            DB::commit();
//
//            return $record;
//        } catch (\Exception $e) {
//            DB::rollback();
//            return redirect()->back()->with(['error' => $e->getMessage()]);
//        }
//
//    }

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

            // Handle videos
            if (isset($attributes['videos'])) {
                foreach ($attributes['videos'] as $video) {
                    $data = [
                        'name' => $video['name'],
                        'youtube_link' => $video['youtube_link'],
                        'publish_date' => $record->publish_date,
                        'videoable_type' => 'Courses',
                        'videoable_id' => $record->id,
                    ];

                    if (isset($video['id'])) {
                        // Find the existing video by ID
                        $existingVideo = Video::find($video['id']);

                        if ($existingVideo) {
                            // Compare if the data has changed
                            if ($existingVideo->name !== $video['name'] ||
                                $existingVideo->youtube_link !== $video['youtube_link']) {
                                // Update the existing video only if there are changes
                                $existingVideo->update($data);
                            }
                        }
                    } else {
                        // Create a new video if no id is present and data is not a duplicate
                        $existingVideo = Video::where('name', $video['name'])
                            ->where('youtube_link', $video['youtube_link'])
                            ->where('videoable_id', $record->id)
                            ->first();

                        if (!$existingVideo) {
                            // Only create a new video if it doesn't already exist
                            Video::create($data);
                        }
                    }
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

//    public function toggleFavorite($courseId)
//    {
//        $user = auth()->user();
//        $course = Course::findOrFail($courseId);
//
//        // Check if the course is already favorited by the user
//        $isFavorited = DB::table('favorites')
//            ->where('favoriteable_id', $course->id)
//            ->where('favoriteable_type', Course::class)
//            ->where('user_id', $user->id)
//            ->exists();
//
//        if ($isFavorited) {
//            // Remove from favorites
//            Favorite::where('favoriteable_id', $course->id)
//                ->where('favoriteable_type', Course::class)
//                ->where('user_id', $user->id)
//                ->delete();
//            $message = __('Course removed from favorites');
//        } else {
//            $data = [
//                'user_id' => $user->id,
//                'favoriteable_id' => $course->id,
//                'favoriteable_type' => Course::class,
//            ];
//            // Add to favorites
//            Favorite::create($data);
//            $message = __('Course added to favorites');
//        }
//
//        return $this->respondWithSuccess($message, [
//            'is_favorited' => !$isFavorited
//        ]);
//    }
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
