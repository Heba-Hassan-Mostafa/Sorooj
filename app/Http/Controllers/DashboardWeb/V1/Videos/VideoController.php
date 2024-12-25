<?php

namespace App\Http\Controllers\DashboardWeb\V1\Videos;

use App\Enum\CategoryTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Web\Videos\VideoRequest;
use App\Models\Video;
use App\Models\Category;
use App\Repositories\Contracts\VideoContract;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    protected VideoContract $repository;

    public function __construct(VideoContract $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = $this->repository->all()->where('videoable_type','Video')->whereNotNull('category_id');

        return view('admin.videos.videos.index', compact('videos'));
    }

    /**
     * Display a listing of the resource.
     */
    public function livewire_index()
    {
        $videos = $this->repository->getLivewireVideos();
        return view('admin.videos.videos.livewire_index',compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('type',CategoryTypeEnum::VIDEO)->get();
        return view('admin.videos.videos.create',compact('categories'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(VideoRequest $request)
    {
        $this->repository->create($request->validated());
        return redirect()->route('admin.videos.videos.index')->with('success', __('dashboard.added-successfully'));

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
         $video = $this->repository->find($id);
        return view('admin.videos.videos.show',compact('video'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categories = Category::where('type',CategoryTypeEnum::VIDEO)->get();
        $video = $this->repository->find($id);
        return view('admin.videos.videos.edit',compact('categories','video'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VideoRequest $request, Video $video)
    {
        $this->repository->update($video,$request->validated());
        return redirect()->route('admin.videos.videos.index')->with('success', __('dashboard.updated-successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video)
    {
        $this->repository->remove($video);
        return redirect()->route('admin.videos.videos.index')->with('success', __('dashboard.deleted-successfully'));
    }

    public function changeStatus(Request $request)
    {
        $this->repository->toggleField($request->id,'status');

        return response()->json(['success'=>'Status change successfully.']);

    }

}
