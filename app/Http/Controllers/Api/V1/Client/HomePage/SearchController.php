<?php

namespace App\Http\Controllers\Api\V1\Client\HomePage;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Client\SearchResource;
use App\Models\Audio;
use App\Models\Blog;
use App\Models\Book;
use App\Models\Course;
use App\Models\FatwaQuestion;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return response()->json(['message' => 'Query is required'], 400);
        }

        // Search in courses using Eloquent
        $courses = Course::where('course_name', 'LIKE', "%{$query}%")
            ->orWhere('course_content', 'LIKE', "%{$query}%")
            ->orWhere('author_name', 'LIKE', "%{$query}%")
            ->select('id', 'course_name as name', 'course_content as description', 'view_count', 'author_name',
                'brief_description', 'publish_date', 'slug', DB::raw('"courses" as type'))
            ->get();

        // Attach media to courses
        $courses = $courses->map(function ($course) {
            $course->image = $course->getFirstMediaUrl('image'); // 'image' is the collection name

            return $course;
        });

        // Search in books using Eloquent
        $books = Book::where('book_name', 'LIKE', "%{$query}%")
            ->orWhere('book_content', 'LIKE', "%{$query}%")
            ->orWhere('author_name', 'LIKE', "%{$query}%")
            ->select('id', 'book_name as name', 'book_content as description', 'view_count', 'author_name',
                'brief_description', 'publish_date', 'slug', DB::raw('"books" as type'))
            ->get();

        // Attach media to books
        $books = $books->map(function ($book) {
            $book->image = $book->getFirstMediaUrl('image'); // 'image' is the collection name
            return $book;
        });

        // Search in blogs using Eloquent
        $blogs = Blog::where('blog_name', 'LIKE', "%{$query}%")
            ->orWhere('blog_content', 'LIKE', "%{$query}%")
            ->orWhere('author_name', 'LIKE', "%{$query}%")
            ->select('id', 'blog_name as name', 'blog_content as description', 'view_count', 'author_name',
                'brief_description', 'publish_date', 'slug', DB::raw('"blogs" as type'))
            ->get();

        // Attach media to blogs
        $blogs = $blogs->map(function ($blog) {
            $blog->image = $blog->getFirstMediaUrl('image'); // 'image' is the collection name
            return $blog;
        });


        // Search in fatwas using Eloquent
        $fatwas = FatwaQuestion::where('status', 1)
            ->where('message', 'LIKE', "%{$query}%")
            ->select('id', 'message as name', 'slug', DB::raw('"fatwas" as type'))
            ->get();

        // Search in audios using Eloquent
        $audios = Audio::where('name', 'LIKE', "%{$query}%")
            ->select('id', 'name as name', 'view_count', 'brief_description', 'publish_date', 'slug', DB::raw('"audios" as type'))
            ->get();

        // Attach media to audios
        $audios = $audios->map(function ($audio) {
            $audio->image = $audio->getFirstMediaUrl('audios'); // 'audios' is the collection name
            return $audio;
        });

        // Combine results
        $merged = $courses
            ->merge($books)
            ->merge($blogs)
            ->merge($audios)
            ->merge($fatwas)
            ->sortByDesc('created_at');

       return SearchResource::collection($merged)->additional([
           'status' => 200,
       ]);



//        // Manual Pagination
//        $page = request()->get('page', 1);
//        $perPage = 10;
//        $paginatedResults = new LengthAwarePaginator(
//            $merged->forPage($page, $perPage), // Items for the current page
//            $merged->count(),                 // Total items
//            $perPage,                         // Items per page
//            $page,                            // Current page
//            ['path' => request()->url()]      // Path for pagination links
//        );
//
//        return response()->json($paginatedResults);
    }

}
