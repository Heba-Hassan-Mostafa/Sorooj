<?php

namespace App\Http\Controllers\DashboardWeb\V1\Blogs;

use App\Enum\CategoryTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Web\Blogs\BlogRequest;
use App\Http\Requests\Dashboard\Web\Blogs\UpdateBlogRequest;
use App\Models\Blog;
use App\Models\Category;
use App\Repositories\Contracts\BlogContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


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
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        DB::beginTransaction();

        try {
            // Update main blog attributes

            $blog->update($request->validated());

            // Update course image
            if (isset($request->image) && $request->image->isValid()) {
                uploadImage('image', $request->image, $blog);
            }
            if (isset($request->audio_file) && $request->audio_file->isValid()) {
                uploadImage('audio_file', $request->audio_file, $blog);
            }

            // Update or Delete Existing Videos
            $existingVideoIds = collect($request->input('videos', []))->pluck('id')->filter();
            $blog->videos()->whereNotIn('id', $existingVideoIds)->delete();

            foreach ($request->input('videos', []) as $videoData) {
                if (isset($videoData['id'])) {
                    $blog->videos()->where('id', $videoData['id'])->update([
                        'name' => $videoData['name'],
                        'youtube_link' => $videoData['youtube_link'],
                    ]);
                }
            }

            // Add New Videos
            if ($request->has('videos.new')) {
                foreach ($request->input('videos.new') as $newVideo) {
                    if ($newVideo) {
                        $lastVideoOrder = $blog->videos()->max('order_position') ?? 0; // Get last order position
                        $blog->videos()->create([
                            'name' => $newVideo['name'],
                            'youtube_link' => $newVideo['youtube_link'],
                            'publish_date' => $blog->publish_date,
                            'videoable_type' => Blog::class,
                            'videoable_id' => $blog->id,
                            'order_position' => $lastVideoOrder + 1,
                        ]);
                    }
                }
            }

            // update attachments
            $this->handleMedia($blog, $request);

            DB::commit();
            return redirect()->route('admin.blogs.blogs.index')->with('success', __('dashboard.updated-successfully'));

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }


    }
    private function handleMedia($blog, $request): void
    {
        if (isset($request->attachments)) {
            foreach ($request->attachments as $media) {
                if (in_array($media->extension(), ['pdf'])) {
                    uploadMedia('attachments', $media, $blog, false);
                }
            }
        }
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

    public function videosSort(Blog $blog)
    {
        $this->repository->getLivewireBlogVideos($blog);
        return view('admin.blogs.blogs.videos-sort',compact('blog'));
    }

    public function deleteAudioFile(Blog $audio)
    {

        if ($audio->hasMedia('audio_file')) {
            $audio->getFirstMedia('audio_file')->delete();
            return response()->json(['success' => true, 'message' => 'audio deleted successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'audio file not found.'], 404);
    }
}
