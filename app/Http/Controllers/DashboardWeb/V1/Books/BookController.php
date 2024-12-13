<?php

namespace App\Http\Controllers\DashboardWeb\V1\Books;

use App\Enum\CategoryTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Web\Books\BookRequest;
use App\Http\Requests\Dashboard\Web\Courses\CourseRequest;
use App\Models\Book;
use App\Models\Category;
use App\Models\Course;
use App\Repositories\Contracts\BookContract;
use App\Repositories\Contracts\CourseContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class BookController extends Controller
{
    protected BookContract $repository;

    public function __construct(BookContract $repository)
    {
        //request()->merge(['loadRelations' => ['category','videos','attachments','media']]);
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = $this->repository->all();

        return view('admin.books.books.index', compact('books'));
    }

    /**
     * Display a listing of the resource.
     */
    public function livewire_index()
    {
        $books = $this->repository->getLivewireBooks();
        return view('admin.books.books.livewire_index',compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::tree()->where('type',CategoryTypeEnum::BOOK);
        return view('admin.books.books.create',compact('categories'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {
        $this->repository->create($request->validated());
        return redirect()->route('admin.books.books.index')->with('success', __('dashboard.added-successfully'));

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
         $book = $this->repository->find($id);
        return view('admin.books.books.show',compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categories = Category::tree()->where('type',CategoryTypeEnum::BOOK);
        $book = $this->repository->find($id);
        return view('admin.books.books.edit',compact('categories','book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookRequest $request, Book $book)
    {

        $this->repository->update($book,$request->validated());
        return redirect()->route('admin.books.books.index')->with('success', __('dashboard.updated-successfully'));


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //TODO: check if this course can be deleted
//        $res = $this->repository->canRemove($course);
//        if (!$res) {
//            return redirect()->route('admin.books.books.index')->with('error', __('dashboard.cannot-delete'));
//        }
        $this->repository->remove($book);
        return redirect()->route('admin.books.books.index')->with('success', __('dashboard.deleted-successfully'));
    }

    public function changeStatus(Request $request)
    {
        $this->repository->toggleField($request->id,'status');

        return response()->json(['success'=>'Status change successfully.']);

    }

    public function deleteBookAttachment(Book $book, $attachmentId)
    {
        // Find the attachment by ID
        $attachment = $book->getMedia('attachments')->find($attachmentId);

        if ($attachment) {
            // Delete the attachment
            $attachment->delete();
            return response()->json(['success' => true, 'message' => 'Attachment deleted successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Attachment not found.'], 404);
    }


    public function deleteBookImage(Book $book)
    {
        // Check if the course has an image
        if ($book->hasMedia('image')) {
            // Delete the image
            $book->getFirstMedia('image')->delete();
            return response()->json(['success' => true, 'message' => 'Image deleted successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Image not found.'], 404);
    }

}
