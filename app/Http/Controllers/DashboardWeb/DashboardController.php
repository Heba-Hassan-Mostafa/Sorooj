<?php

namespace App\Http\Controllers\DashboardWeb;

use App\Http\Controllers\Controller;
use App\Models\Audio;
use App\Models\Blog;
use App\Models\Book;
use App\Models\Course;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{


    public function index()
    {
        // Fetch top viewed courses and books
        $courses = Course::select('id', 'course_name as name', 'view_count')
            ->addSelect(DB::raw("'courses' as type")) // Add type as a raw SQL value
            ->orderByDesc('view_count')
            ->limit(10)
            ->get();

        $books = Book::select('id', 'book_name as name', 'view_count')
            ->addSelect(DB::raw("'books' as type")) // Add type as a raw SQL value
            ->orderByDesc('view_count')
            ->limit(10)
            ->get();

        $blogs = Blog::select('id', 'blog_name as name', 'view_count')
            ->addSelect(DB::raw("'blogs' as type")) // Add type as a raw SQL value
            ->orderByDesc('view_count')
            ->limit(10)
            ->get();
        $audios = Audio::select('id', 'name as name', 'view_count')
            ->addSelect(DB::raw("'audios' as type")) // Add type as a raw SQL value
            ->orderByDesc('view_count')
            ->limit(10)
            ->get();

        // Merge, sort by views, and limit the combined results
        $mostViewed = $courses->merge($books)->merge($blogs)->merge($audios)
            ->sortByDesc('view_count')
            ->take(6)
            ->values();


        $mostFavorited = DB::table('favorites')
            ->select('favoriteable_type', 'favoriteable_id', DB::raw('COUNT(*) as total'))
            ->groupBy('favoriteable_type', 'favoriteable_id')
            ->orderByDesc('total')
            ->get();

// Map and resolve the names
        $favoriteableMappings = [
            'Course' => \App\Models\Course::class,
            'Book' => \App\Models\Book::class,
        ];

        $result = $mostFavorited->map(function ($favorite) use ($favoriteableMappings) {
            $modelClass = $favoriteableMappings[$favorite->favoriteable_type] ?? null;

            if ($modelClass && class_exists($modelClass)) {
                $item = $modelClass::find($favorite->favoriteable_id); // Retrieve the model instance
                if ($item) {
                    $name = match ($favorite->favoriteable_type) {
                        'Course' => $item->course_name ?? 'Unknown Course',
                        'Book' => $item->book_name ?? 'Unknown Book',
                        default => 'Unknown Item',
                    };

                    return [
                        'name' => $name,
                        'type' => $favorite->favoriteable_type,
                        'image' => $item->image ?? null,
                        'total' => $favorite->total,
                    ];
                }
            }

            return [
                'name' => 'Unknown Item',
                'type' => $favorite->favoriteable_type,
                'image' => null,
                'total' => $favorite->total,
            ];
        });


        return view('admin.dashboard', compact('mostViewed', 'result'));
    }

}
