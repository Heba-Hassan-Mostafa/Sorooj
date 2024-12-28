<?php

namespace App\Http\Resources\Api\V1\Client;

use App\Http\Resources\Api\V1\Client\Books\BookResource;
use App\Http\Resources\Api\V1\Client\Courses\CourseResource;
use App\Models\Book;
use App\Models\Course;
use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteResource extends JsonResource
{
    public function toArray($request)
    {
        // Get the related favoriteable model (either Course or Book)
        $favoriteable = $this->favoriteable;

        $response = [
            'id' => $this->id,
        ];

        if ($favoriteable instanceof Course) {
            $response['type'] = 'courses';
            $response['_type'] = __('courses');
            $response['course'] = (new CourseResource($favoriteable))->toArray($request);
        }

        if ($favoriteable instanceof Book) {
            $response['type'] = 'books';
            $response['_type'] = __('books');
            $response['book'] = (new BookResource($favoriteable))->toArray($request);
        }

        return $response; // Return the complete response array
    }
}
