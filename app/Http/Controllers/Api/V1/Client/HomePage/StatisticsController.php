<?php

namespace App\Http\Controllers\Api\V1\Client\HomePage;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Client\SliderResource;
use App\Models\Book;
use App\Models\Course;
use App\Models\FatwaQuestion;
use App\Models\Subscriber;
use App\Models\Video;
use App\Repositories\Contracts\SliderContract;
use Illuminate\Http\JsonResponse;

class StatisticsController extends Controller
{
    public function index(){
        $data = [];
        $data['courses'] = Course::Active()->ActiveCategory()->Publish()->count();
        $data['books'] = Book::Active()->ActiveCategory()->Publish()->count();
        $data['videos'] = Video::where('videoable_type','Video')->Active()->ActiveCategory()->Publish()->count();
        $data['questions'] = FatwaQuestion::whereHas('fatwaAnswer')->Active()->count();
        $data['subscribers'] = Subscriber::count();
        return response()->json([
            'status' => 200,
            'data' => $data,
        ], 200);
    }


}
