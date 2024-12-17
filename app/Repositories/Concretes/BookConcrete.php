<?php

namespace App\Repositories\Concretes;

use App\Models\Book;
use App\Models\Course;

use App\Repositories\Contracts\BookContract;
use App\Traits\ApiResponseTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BookConcrete extends BaseConcrete implements BookContract
{
    use ApiResponseTrait;
    /**
     * AdminConcrete constructor.
     * @param Book $model
     */

    public function __construct(Book $model)
    {
        parent::__construct($model);
    }

    public function getLivewireBooks()
    {
        return Book::with(['category'])->get();
    }


    public function create(array $attributes = []): mixed
    {
        DB::beginTransaction();

        try {

            $lastOrderPosition = Book::max('order_position');
            $nextOrderPosition = $lastOrderPosition + 1;

            // Include the next order position in the attributes
            $attributes['order_position'] = $nextOrderPosition;

         // create book
        $record = parent::create($attributes);

        // store book image
        if (isset($attributes['image']) && $attributes['image']->isValid()) {
            uploadImage('image', $attributes['image'], $record);
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
            // Update main book attributes

            $record = parent::update($model, $attributes);

           // Update book image
            if (isset($attributes['image']) && $attributes['image']->isValid()) {
                uploadImage('image', $attributes['image'], $record);
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



    // add comment to book
    public function addBookComment($bookId, array $attributes = [])
    {
        try {
            $book = Book::whereId($bookId)->Active()->ActiveCategory()->first();

            if (!$book) {
                throw new \Exception('Book not found or inactive.');
            }

            $attributes['user_id'] = auth()->id();
            $attributes['commentable_id'] = $book->id;
            $attributes['commentable_type'] = Book::class;

            $comment = $book->comments()->create($attributes);

            return $comment;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function suggestedBooks()
    {
        $randomBooks = Book::with('media')
            ->ActiveCategory()->Active()->Publish()->inRandomOrder()->paginate(3);

        return $randomBooks;

    }


    public function toggleFavorite($id)
    {
        $book = Book::findOrFail($id);
        $userId = auth(activeGuard())?->user()->id;
        $existingFavorite =  $book->favorites()->where('user_id', $userId)->first();
        if ($existingFavorite) {
            $existingFavorite->delete();
            return $this->respondWithSuccess(__('Book removed from favorites'), ['is_favorite' => false]);
        } else {

         $book->favorites()->create([
                'user_id' => auth()->id(),
            ]);
            return $this->respondWithSuccess(__('Book added to favorites'), ['is_favorite' => true]);
        }

    }

}
