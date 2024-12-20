<?php

namespace App\Http\Controllers\Api\V1\Client\HomePage;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Client\MostViewedResource;
use App\Models\Book;
use App\Models\Course;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class MostViewedController extends Controller
{
    use ApiResponseTrait;
    public function index(): JsonResponse
    {
        // Fetch top viewed courses and books
        $courses = Course::select('id', 'course_name as name', 'view_count','author_name as author_name',
            'brief_description as brief_description', 'publish_date as publish_date','slug as slug')
            ->addSelect(DB::raw("'course' as type")) // Add type as a raw SQL value
            ->orderByDesc('view_count')
            ->limit(10)
            ->get();

        $books = Book::select('id', 'book_name as name', 'view_count','author_name as author_name',
            'brief_description as brief_description', 'publish_date as publish_date','slug as slug')
            ->addSelect(DB::raw("'book' as type")) // Add type as a raw SQL value
            ->orderByDesc('view_count')
            ->limit(10)
            ->get();

        // Merge, sort by views, and limit the combined results
        $mostViewed = $courses->merge($books)
            ->sortByDesc('view_count')
            ->take(4)
            ->values();

      //  return response()->json(['data' => $mostViewed]);
        return $this->respondWithSuccess(__('Most Viewed'), [
            'most_viewed' => MostViewedResource::collection($mostViewed),
        ]);
    }
}
