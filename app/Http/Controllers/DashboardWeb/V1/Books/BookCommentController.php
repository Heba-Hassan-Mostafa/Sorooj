<?php

namespace App\Http\Controllers\DashboardWeb\V1\Books;

use App\Enum\CategoryTypeEnum;
use App\Enum\CommentStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Web\Courses\CourseRequest;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Course;
use App\Repositories\Contracts\CommentContract;
use App\Repositories\Contracts\CourseContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class BookCommentController extends Controller
{
    protected CommentContract $repository;

    public function __construct(CommentContract $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = $this->repository->all()->where('commentable_type','Book');

        return view('admin.books.comments.index', compact('comments'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {

        $this->repository->remove($comment);
        return redirect()->route('admin.books.comments.index')->with('success', __('dashboard.deleted-successfully'));
    }

    public function changeStatus(Request $request)
    {
        $this->repository->toggleField($request->id,'is_active');

        $comment = $this->repository->find($request->id);

        if ($request->is_active == 1) {
            $comment->update(['status' => CommentStatusEnum::PUBLISHED]);
        } else {
            $comment->update(['status' => CommentStatusEnum::UNPUBLISHED]);
        }
        return response()->json(['success'=>'Status change successfully.']);

    }

}
