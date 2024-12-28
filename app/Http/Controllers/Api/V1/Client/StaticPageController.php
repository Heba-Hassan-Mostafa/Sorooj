<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class StaticPageController extends Controller
{
    use ApiResponseTrait;

    public function getAboutCenter(): JsonResponse
    {
        $data['data'] = collect(setting('about-center'))->toArray() ?? '';
        $data['status'] = 200;
        return $this->setStatusCode(200)->respondWithArray($data);
    }


    public function getVision(): JsonResponse
    {
        $data['data'] = collect(setting('vision'))->toArray() ?? '';
        $data['status'] = 200;
        return $this->setStatusCode(200)->respondWithArray($data);
    }

    public function getMessage(): JsonResponse
    {
        $data['data'] = collect(setting('message'))->toArray() ?? '';
        $data['status'] = 200;
        return $this->setStatusCode(200)->respondWithArray($data);
    }
    public function getGeneralObjectives(): JsonResponse
    {
        $data['data'] = collect(setting('general-objectives'))->toArray() ?? '';
        $data['status'] = 200;
        return $this->setStatusCode(200)->respondWithArray($data);
    }
    public function getTracksCenterAreas(): JsonResponse
    {
        $track = setting('tracks-center-areas');
        $content = $track->content ?? '';
        $data = [
            'data' => [
                'content' => $content,
                'tracks' =>json_decode($track->tracks, true) ?? [],
            ],
            'status' => 200
        ];
        return $this->setStatusCode(200)->respondWithArray($data);
    }
    public function getCenterMechanism(): JsonResponse
    {
        $points = setting('center-mechanism');
        $data = [
            'data' => [
                'points' =>json_decode($points->points, true) ?? [],
            ],
            'status' => 200
        ];
        return $this->setStatusCode(200)->respondWithArray($data);
    }
    public function getContactsInfo(): JsonResponse
    {
        $data['data'] = collect(setting('app-contacts'))->toArray() ?? '';
        $data['status'] = 200;
        return $this->setStatusCode(200)->respondWithArray($data);
    }


}
