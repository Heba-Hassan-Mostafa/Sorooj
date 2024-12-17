<?php

namespace App\Http\Controllers\DashboardWeb\V1\Blogs;

use App\Enum\CategoryTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Web\Blogs\BlogRequest;
use App\Models\Blog;
use App\Models\Category;
use App\Repositories\Contracts\BlogContract;
use Illuminate\Http\Request;


class BlogController extends Controller
{
    protected BlogContract $repository;

    public function __construct(BlogContract $repository)
    {
        //request()->merge(['loadRelations' => ['category','videos','attachments','media']]);
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = $this->repository->all();

        return view('admin.blogs.blogs.index', compact('blogs'));
    }

    /**
     * Display a listing of the resource.
     */
    public function livewire_index()
    {
        $blogs = $this->repository->getLivewireBlogs();
        return view('admin.blogs.blogs.livewire_index',compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::tree()->where('type',CategoryTypeEnum::BLOG);
        return view('admin.blogs.blogs.create',compact('categories'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogRequest $request)
    {
        $this->repository->create($request->validated());
        return redirect()->route('admin.blogs.blogs.index')->with('success', __('dashboard.added-successfully'));

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
         $blog = $this->repository->find($id);
        return view('admin.blogs.blogs.show',compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categories = Category::tree()->where('type',CategoryTypeEnum::BLOG);
        $blog = $this->repository->find($id);
        return view('admin.blogs.blogs.edit',compact('categories','blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogRequest $request, Blog $blog)
    {

        $this->repository->update($blog,$request->validated());
        return redirect()->route('admin.blogs.blogs.index')->with('success', __('dashboard.updated-successfully'));


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        //TODO: check if this course can be deleted
//        $res = $this->repository->canRemove($course);
//        if (!$res) {
//            return redirect()->route('admin.blogs.blogs.index')->with('error', __('dashboard.cannot-delete'));
//        }
        $this->repository->remove($blog);
        return redirect()->route('admin.blogs.blogs.index')->with('success', __('dashboard.deleted-successfully'));
    }

    public function changeStatus(Request $request)
    {
        $this->repository->toggleField($request->id,'status');

        return response()->json(['success'=>'Status change successfully.']);

    }

    public function deleteBlogAttachment(Blog $blog, $attachmentId)
    {
        // Find the attachment by ID
        $attachment = $blog->getMedia('attachments')->find($attachmentId);

        if ($attachment) {
            // Delete the attachment
            $attachment->delete();
            return response()->json(['success' => true, 'message' => 'Attachment deleted successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Attachment not found.'], 404);
    }


    public function deleteBlogImage(Blog $blog)
    {
        // Check if the course has an image
        if ($blog->hasMedia('image')) {
            // Delete the image
            $blog->getFirstMedia('image')->delete();
            return response()->json(['success' => true, 'message' => 'Image deleted successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Image not found.'], 404);
    }

    public function deleteBlogVideo(Blog $blog)
    {
        if ($blog->has('videos')) {
            $blog->videos()->update([
                'name' => null,
                'youtube_link' => null
            ]);
            return response()->json(['success' => true, 'message' => 'video deleted successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'video not found.'], 404);
    }


}
