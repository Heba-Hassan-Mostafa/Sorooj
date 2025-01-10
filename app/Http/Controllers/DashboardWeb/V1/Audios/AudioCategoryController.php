<?php

namespace App\Http\Controllers\DashboardWeb\V1\Audios;

use App\Enum\CategoryTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Web\Audios\CategoryRequest;
use App\Models\Category;
use App\Repositories\Contracts\AudioCategoryContract;
use Illuminate\Http\Request;


class AudioCategoryController extends Controller
{
    protected AudioCategoryContract $repository;

    public function __construct(AudioCategoryContract $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->repository->all()
            ->where('parent_id',null)->where('type',CategoryTypeEnum::AUDIO);
        return view('admin.audios.categories.index', compact('categories'));
    }

    public function livewire_index()
    {
        $categories = $this->repository->getLivewireCategories();
        return view('admin.audios.categories.livewire_index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.audios.categories.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $this->repository->create($request->validated());
        return redirect()->route('admin.audios.category.index')->with('success', __('dashboard.added-successfully'));

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
         $category = $this->repository->find($id);
        return view('admin.audios.categories.show',compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = $this->repository->find($id);
        return view('admin.audios.categories.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $this->repository->update($category,$request->validated());
        return redirect()->route('admin.audios.category.index')->with('success', __('dashboard.updated-successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $res = $this->repository->canRemove($category);
        if (!$res) {
            return redirect()->route('admin.audios.category.index')->with('error', __('dashboard.cannot-delete'));
        }
        $this->repository->remove($category);
        return redirect()->route('admin.audios.category.index')->with('success', __('dashboard.deleted-successfully'));
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
