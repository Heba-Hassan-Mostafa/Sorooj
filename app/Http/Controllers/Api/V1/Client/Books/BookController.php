<?php

namespace App\Http\Controllers\Api\V1\Client\Books;

use App\Http\Requests\Api\V1\Client\Courses\CommentRequest;
use App\Http\Resources\Api\V1\Client\Books\BookCommentResource;
use App\Http\Resources\Api\V1\Client\Books\BookResource;
use App\Http\Controllers\Api\BaseApiController;
use App\Models\Book;
use App\Repositories\Contracts\BookContract;
use Illuminate\Http\JsonResponse;

class BookController extends BaseApiController
{
    /**
     * CategoryController constructor.
     * @param BookContract $repository
     */

    protected array $conditions = ['where' => ['status' => 1]];
    protected string $orderBy = 'order_position';


    public function __construct(BookContract $repository)
    {
        request()->merge(['loadRelations' => 'category','media','favorites']);
        parent::__construct($repository, BookResource::class);
    }


    /**
     * Display the specified resource.
     *
     * @param $slug
     * @return JsonResponse
     */
    public function show($slug): JsonResponse
    {
        $course = Book::with(['category', 'media', 'favorites'])
            ->where('slug', $slug)
            ->firstOrFail();

        $course->increment('view_count');
        return $this->respondWithSuccess(__('Books details'), [
            'Books' => (new BookResource($course)),
        ]);
    }


    public function addComment(CommentRequest $request, $id): JsonResponse
    {
        try {
            $comment = $this->repository->addBookComment($id, $request->validated());

            if (!$comment) {
                return $this->respondWithError(__('Failed to add comment. Please try again.'));
            }

            return $this->respondWithSuccess(__('Comment added successfully'), [
                'comment' => new BookCommentResource($comment),
            ]);
        } catch (\Exception $e) {
            return $this->respondWithError(__('An error occurred: ') . $e->getMessage());
        }
    }


    public function suggestedBooks()
    {
        $books = $this->repository->suggestedBooks();
        return $this->respondWithSuccess(__('Suggested Books'), [
            'suggested-Books' => BookResource::collection($books),
        ]);

    }


    public function toggleFavorite($bookId)
    {
       return $this->repository->toggleFavorite($bookId);
    }

}
