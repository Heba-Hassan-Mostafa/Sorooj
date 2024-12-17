<?php

namespace App\Http\Controllers\DashboardWeb\V1\Blogs;

use App\Enum\CategoryTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Web\Blogs\CategoryRequest;
use App\Models\Category;
use App\Repositories\Contracts\BlogCategoryContract;
use Illuminate\Http\Request;


class BlogCategoryController extends Controller
{
    protected BlogCategoryContract $repository;

    public function __construct(BlogCategoryContract $repository)
    {
        request()->merge(['loadRelations' => ['subcategory','parent']]);
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->repository->all()
            ->where('parent_id',null)->where('type',CategoryTypeEnum::BLOG);
        $subCategories = $this->repository->all()->where('parent_id','!=',null)
            ->where('type',CategoryTypeEnum::BLOG);

        return view('admin.blogs.categories.index', compact('categories', 'subCategories'));
    }

    public function livewire_index()
    {
        $categories = $this->repository->getLivewireCategories();
        return view('admin.blogs.categories.livewire_index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::tree()->where('type',CategoryTypeEnum::BLOG);
        return view('admin.blogs.categories.create',compact('categories'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $this->repository->create($request->validated());
        return redirect()->route('admin.blogs.category.index')->with('success', __('dashboard.added-successfully'));

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = $this->repository->find($id);
        return view('admin.blogs.categories.show',compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = $this->repository->find($id);
        $parentCategories = Category::tree()->where('type',CategoryTypeEnum::BLOG);
        return view('admin.blogs.categories.edit',compact('category','parentCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $this->repository->update($category,$request->validated());
        return redirect()->route('admin.blogs.category.index')->with('success', __('dashboard.updated-successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $res = $this->repository->canRemove($category);
        if (!$res) {
            return redirect()->route('admin.blogs.category.index')->with('error', __('dashboard.cannot-delete'));
        }
        $this->repository->remove($category);
        return redirect()->route('admin.blogs.category.index')->with('success', __('dashboard.deleted-successfully'));
    }

    public function changeStatus(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $newStatus = $request->status;

        // Update the status of the selected category
        $category->status = $newStatus;
        $category->save();

        // Update the status of all subcategories recursively
        $this->updateSubcategoriesStatus($category->id, $newStatus);

        return response()->json(['success' => 'Status changed successfully.']);
    }

    /**
     * Update the status of all subcategories recursively.
     */
    private function updateSubcategoriesStatus($parentId, $status)
    {
        $subcategories = Category::where('parent_id', $parentId)->get();

        foreach ($subcategories as $subcategory) {
            $subcategory->status = $status;
            $subcategory->save();

            // Recursively update subcategories of this subcategory
            $this->updateSubcategoriesStatus($subcategory->id, $status);
        }
    }

}
