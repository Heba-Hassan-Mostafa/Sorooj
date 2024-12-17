<?php

namespace App\Repositories\Concretes;

use App\Models\Blog;

use App\Repositories\Contracts\BlogContract;
use App\Traits\ApiResponseTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BlogConcrete extends BaseConcrete implements BlogContract
{
    use ApiResponseTrait;
    /**
     * AdminConcrete constructor.
     * @param Blog $model
     */

    public function __construct(Blog $model)
    {
        parent::__construct($model);
    }

    public function getLivewireBlogs()
    {
        return Blog::with(['category'])->get();
    }


    public function create(array $attributes = []): mixed
    {
        DB::beginTransaction();

        try {

            $lastOrderPosition = Blog::max('order_position');
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

                    $record->videos()->create([
                        'name' => $attributes['video_name'],
                        'youtube_link' => $attributes['youtube_link'],
                        'publish_date' => $record->publish_date,
                        'videoable_type' => Blog::class,
                        'videoable_id' => $record->id,
                    ]);



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
            // Update main blog attributes

            $record = parent::update($model, $attributes);

           // Update course image
            if (isset($attributes['image']) && $attributes['image']->isValid()) {
                uploadImage('image', $attributes['image'], $record);
            }

        // Update videos

                    // Create new video
                    $record->videos()->update([
                        'name' => $attributes['video_name'],
                        'youtube_link' => $attributes['youtube_link'],
                        'publish_date' => $record->publish_date,
                    ]);


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
    public function addComment($blogId, array $attributes = [])
    {
        try {
            $blog = Blog::whereId($blogId)->Active()->ActiveCategory()->first();

            if (!$blog) {
                throw new \Exception('Blog not found or inactive.');
            }

            $attributes['user_id'] = auth()->id();
            $attributes['commentable_id'] = $blog->id;
            $attributes['commentable_type'] = Blog::class;

            $comment = $blog->comments()->create($attributes);

            return $comment;
        } catch (\Exception $e) {
            throw $e; // Re-throw the exception for the controller to handle
        }
    }

    public function suggestedBlogs()
    {
        $randomBlogs = Blog::with('media')
            ->ActiveCategory()->Active()->Publish()->inRandomOrder()->paginate(3);

        return $randomBlogs;

    }


    public function toggleFavorite($id)
    {
        $blog = Blog::findOrFail($id);
        $userId = auth(activeGuard())?->user()->id;
        $existingFavorite =  $blog->favorites()->where('user_id', $userId)->first();
        if ($existingFavorite) {
            $existingFavorite->delete();
            return $this->respondWithSuccess(__('Blog removed from favorites'), ['is_favorite' => false]);
        } else {

         $blog->favorites()->create([
                'user_id' => auth()->id(),
            ]);
            return $this->respondWithSuccess(__('Blog added to favorites'), ['is_favorite' => true]);
        }

    }

}
