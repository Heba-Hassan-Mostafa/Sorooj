<?php

namespace App\Http\Controllers\DashboardWeb\V1\Courses;

use App\Enum\CategoryTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Web\Courses\CourseRequest;
use App\Models\Category;
use App\Models\Course;
use App\Repositories\Contracts\CourseContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CourseController extends Controller
{
    protected CourseContract $repository;

    public function __construct(CourseContract $repository)
    {
        //request()->merge(['loadRelations' => ['category','videos','attachments','media']]);
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = $this->repository->all();

        return view('admin.courses.courses.index', compact('courses'));
    }

    /**
     * Display a listing of the resource.
     */
    public function livewire_index()
    {
        $courses = $this->repository->getLivewireCourses();
        return view('admin.courses.courses.livewire_index',compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::tree()->where('type',CategoryTypeEnum::COURSE);
        return view('admin.courses.courses.create',compact('categories'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseRequest $request)
    {
        $this->repository->create($request->validated());
        return redirect()->route('admin.courses.courses.index')->with('success', __('dashboard.added-successfully'));

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
         $course = $this->repository->find($id);
        return view('admin.courses.courses.show',compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categories = Category::tree()->where('type',CategoryTypeEnum::COURSE);
        $course = $this->repository->find($id);
        return view('admin.courses.courses.edit',compact('categories','course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseRequest $request, Course $course)
    {

        $this->repository->update($course,$request->validated());
        return redirect()->route('admin.courses.courses.index')->with('success', __('dashboard.updated-successfully'));


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //TODO: check if this course can be deleted
//        $res = $this->repository->canRemove($course);
//        if (!$res) {
//            return redirect()->route('admin.courses.courses.index')->with('error', __('dashboard.cannot-delete'));
//        }
        $this->repository->remove($course);
        return redirect()->route('admin.courses.courses.index')->with('success', __('dashboard.deleted-successfully'));
    }

    public function changeStatus(Request $request)
    {
        $this->repository->toggleField($request->id,'status');

        return response()->json(['success'=>'Status change successfully.']);

    }

    public function deleteCourseAttachment(Course $course, $attachmentId)
    {
        // Find the attachment by ID
        $attachment = $course->getMedia('attachments')->find($attachmentId);

        if ($attachment) {
            // Delete the attachment
            $attachment->delete();
            return response()->json(['success' => true, 'message' => 'Attachment deleted successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Attachment not found.'], 404);
    }


    public function deleteCourseImage(Course $course)
    {
        // Check if the course has an image
        if ($course->hasMedia('image')) {
            // Delete the image
            $course->getFirstMedia('image')->delete();
            return response()->json(['success' => true, 'message' => 'Image deleted successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Image not found.'], 404);
    }

    public function videosSort(Course $course)
    {
       $this->repository->getLivewireCourseVideos($course);
        return view('admin.courses.courses.videos-sort',compact('course'));
    }


}
