<?php

namespace App\Http\Controllers\DashboardWeb\V1\Videos;

use App\Enum\CategoryTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Web\Courses\CategoryRequest;
use App\Models\Category;
use App\Repositories\Contracts\VideoCategoryContract;
use Illuminate\Http\Request;


class VideoCategoryController extends Controller
{
    protected VideoCategoryContract $repository;

    public function __construct(VideoCategoryContract $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->repository->all()
            ->where('parent_id',null)->where('type',CategoryTypeEnum::VIDEO);
        return view('admin.videos.categories.index', compact('categories'));
    }

    public function livewire_index()
    {
        $categories = $this->repository->getLivewireCategories();
        return view('admin.videos.categories.livewire_index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.videos.categories.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $this->repository->create($request->validated());
        return redirect()->route('admin.videos.category.index')->with('success', __('dashboard.added-successfully'));

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
         $category = $this->repository->find($id);
        return view('admin.videos.categories.show',compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = $this->repository->find($id);
        return view('admin.videos.categories.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $this->repository->update($category,$request->validated());
        return redirect()->route('admin.videos.category.index')->with('success', __('dashboard.updated-successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $res = $this->repository->canRemove($category);
        if (!$res) {
            return redirect()->route('admin.videos.category.index')->with('error', __('dashboard.cannot-delete'));
        }
        $this->repository->remove($category);
        return redirect()->route('admin.videos.category.index')->with('success', __('dashboard.deleted-successfully'));
    }

    public function changeStatus(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $newStatus = $request->status;

        // Update the status of the selected category
        $category->status = $newStatus;
        $category->save();

        return response()->json(['success' => 'Status changed successfully.']);
    }

}
