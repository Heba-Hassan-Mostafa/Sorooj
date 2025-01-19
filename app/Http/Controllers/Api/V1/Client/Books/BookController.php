<?php

namespace App\Http\Controllers\Api\V1\Client\Books;

use App\Http\Requests\Api\V1\Client\Courses\CommentRequest;
use App\Http\Resources\Api\V1\Client\Books\BookCommentResource;
use App\Http\Resources\Api\V1\Client\Books\BookResource;
use App\Http\Controllers\Api\BaseApiController;
use App\Models\Book;
use App\Models\Course;
use App\Repositories\Contracts\BookContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
        $book = Book::with(['category', 'media', 'favorites'])
            ->where('slug', $slug)
            ->firstOrFail();

       // $book->increment('view_count');
        return $this->respondWithSuccess(__('Books details'), [
            'Books' => (new BookResource($book)),
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
            'suggested_Books' => BookResource::collection($books),
        ]);

    }


    public function toggleFavorite($bookId)
    {
       return $this->repository->toggleFavorite($bookId);
    }


    public function getFavorites()
    {
        $favorites = $this->repository->getFavorites();
        return $this->respondWithCollection($favorites);

    }

    public function setBookViewCount(Request $request,$slug): JsonResponse
    {
        $validated = $request->validate([
            'view_count' => 'required|integer',
        ]);
        $book = Book::where('slug', $slug)->firstOrFail();
        $book->update(['view_count' => $validated['view_count']]);
        return $this->respondWithSuccess(__('View count updated successfully'));
    }

    public function setBookDownloadCount(Request $request,$slug): JsonResponse
    {
        $validated = $request->validate([
            'download_count' => 'required|integer',
        ]);
        $book = Book::where('slug', $slug)->firstOrFail();
        $book->update(['download_count' => $validated['download_count']]);
        return $this->respondWithSuccess(__('Download count updated successfully'));
    }

}
