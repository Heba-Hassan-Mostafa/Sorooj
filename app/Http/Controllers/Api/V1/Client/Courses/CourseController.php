<?php

namespace App\Http\Controllers\Api\V1\Client\Courses;

use App\Http\Requests\Api\V1\Client\Courses\CommentRequest;
use App\Http\Resources\Api\V1\Client\Courses\CourseCommentResource;
use App\Http\Resources\Api\V1\Client\Courses\CourseResource;
use App\Http\Controllers\Api\BaseApiController;
use App\Models\Course;
use App\Repositories\Contracts\CourseContract;
use Illuminate\Http\JsonResponse;

class CourseController extends BaseApiController
{
    /**
     * CategoryController constructor.
     * @param CourseContract $repository
     */

    protected array $conditions = ['where' => ['status' => 1]];
    protected string $orderBy = 'order_position';


    public function __construct(CourseContract $repository)
    {
       // request()->merge(['loadRelations' => 'category','videos','media','favorites','subscriptions']);
        parent::__construct($repository, CourseResource::class);
    }


    /**
     * Display the specified resource.
     *
     * @param Course $Course
     * @return JsonResponse
     */
    public function show($slug): JsonResponse
    {
        //$course = Course::with(['videos','category','media','favorites'])->findOrFail($id);
        $course = Course::with(['videos', 'category', 'media', 'favorites'])
            ->where('slug', $slug)
            ->firstOrFail();

        $course->increment('view_count');
        return $this->respondWithSuccess(__('Courses details'), [
            'Courses' => (new CourseResource($course)),
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
                'comment' => new CourseCommentResource($comment),
            ]);
        } catch (\Exception $e) {
            return $this->respondWithError(__('An error occurred: ') . $e->getMessage());
        }
    }


    public function suggestedCourses()
    {
        $courses = $this->repository->suggestedCourses();
        return $this->respondWithSuccess(__('Suggested courses'), [
            'suggested_courses' => CourseResource::collection($courses),
        ]);

    }


    public function toggleFavorite($courseId)
    {
       return $this->repository->toggleFavorite($courseId);
    }

    public function addSubscription($courseId)
    {
        return $this->repository->addSubscription($courseId);
    }

    public function getFavorites()
    {
        $favorites = $this->repository->getFavorites();
        return $this->respondWithCollection($favorites);

    }
    public function getSubscriptions()
    {
        $subscriptions = $this->repository->getMySubscriptions();
        return $this->respondWithCollection($subscriptions);

    }
}
