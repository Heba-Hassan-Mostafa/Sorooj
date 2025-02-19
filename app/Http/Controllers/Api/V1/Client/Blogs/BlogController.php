<?php

namespace App\Http\Controllers\Api\V1\Client\Blogs;

use App\Http\Requests\Api\V1\Client\Courses\CommentRequest;
use App\Http\Resources\Api\V1\Client\Blogs\BlogResource;
use App\Http\Resources\Api\V1\Client\Blogs\BlogCommentResource;
use App\Http\Controllers\Api\BaseApiController;
use App\Models\Blog;
use App\Repositories\Contracts\BlogContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlogController extends BaseApiController
{
    /**
     * CategoryController constructor.
     * @param BlogContract $repository
     */

    protected array $conditions = ['where' => ['status' => 1]];
    protected string $orderBy = 'order_position';


    public function __construct(BlogContract $repository)
    {
        request()->merge(['loadRelations' => 'category','videos','media','favorites']);
        parent::__construct($repository, BlogResource::class);
    }


    /**
     * Display the specified resource.
     *
     * @param Blog $Blog
     * @return JsonResponse
     */
    public function show($slug): JsonResponse
    {
        $blog = Blog::with(['videos', 'category', 'media', 'favorites'])
            ->where('slug', $slug)
            ->firstOrFail();

       // $blog->increment('view_count');
        return $this->respondWithSuccess(__('Blogs details'), [
            'Blogs' => (new BlogResource($blog)),
        ]);
    }


    public function addComment(CommentRequest $request, $id)
    {
        try {
            $comment = $this->repository->addComment($id, $request->validated());

            if (!$comment) {
                return $this->respondWithError(__('Failed to add comment. Please try again.'));
            }

            return $this->respondWithSuccess(__('Comment added successfully'), [
                'comment' => new BlogCommentResource($comment),
            ]);
        } catch (\Exception $e) {
            return $this->respondWithError(__('An error occurred: ') . $e->getMessage());
        }
    }


    public function suggestedBlogs()
    {
        $blogs = $this->repository->suggestedBlogs();
        return $this->respondWithSuccess(__('Suggested blogs'), [
            'suggested_blogs' => BlogResource::collection($blogs),
        ]);

    }

    public function toggleFavorite($blogId)
    {
       return $this->repository->toggleFavorite($blogId);
    }

    public function setBlogViewCount(Request $request,$slug): JsonResponse
    {
        $validated = $request->validate([
            'view_count' => 'required|integer',
        ]);
        $blog = Blog::where('slug', $slug)->firstOrFail();
        $blog->update(['view_count' => $validated['view_count']]);
        return $this->respondWithSuccess(__('View count updated successfully'));
    }

    public function setBlogDownloadCount(Request $request,$slug): JsonResponse
    {
        $validated = $request->validate([
            'download_count' => 'required|integer',
        ]);
        $blog = Blog::where('slug', $slug)->firstOrFail();
        $blog->update(['download_count' => $validated['download_count']]);
        return $this->respondWithSuccess(__('Download count updated successfully'));
    }

}
