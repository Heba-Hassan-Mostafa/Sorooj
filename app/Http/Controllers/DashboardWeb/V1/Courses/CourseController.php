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
        request()->merge(['loadRelations' => ['category','videos','attachments','media']]);
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

//        public function update(CourseRequest $request, $id)
//    {
//        DB::beginTransaction();
//        try {
//            // Find course
//            $course = $this->repository->find($id);
//
//            // Update course details
//            $this->repository->update($course, $request->validated());
//
//            // Handle course image
//            if ($request->hasFile('image') && $request->file('image')->isValid()) {
//                uploadImage('image', $request->file('image'), $course);
//            }
//
//            // Update videos
//            if ($request->has('videos')) {
//                $existingVideos = $course->videos->keyBy('id');
//                foreach ($request->input('videos') as $video) {
//                    if (isset($video['id']) && $existingVideos->has($video['id'])) {
//                        // Update existing video
//                        $existingVideos->get($video['id'])->update([
//                            'name' => $video['name'],
//                            'youtube_link' => $video['youtube_link'],
//                            'publish_date' => $course->publish_date,
//                        ]);
//                        $existingVideos->forget($video['id']);
//                    } else {
//                        // Create new video
//                        $course->videos()->create([
//                            'name' => $video['name'],
//                            'youtube_link' => $video['youtube_link'],
//                            'publish_date' => $course->publish_date,
//                        ]);
//                    }
//                }
//
//                // Delete removed videos
//                foreach ($existingVideos as $remainingVideo) {
//                    $remainingVideo->delete();
//                }
//            }
//
//            DB::commit();
//            return redirect()->route('admin.courses.courses.index')->with('success', __('dashboard.updated-successfully'));
//        } catch (\Exception $e) {
//            DB::rollBack();
//            return redirect()->back()->with(['error' => $e->getMessage()]);
//        }
//    }

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


}
