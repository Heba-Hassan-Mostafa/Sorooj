<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class StaticPageController extends Controller
{
    use ApiResponseTrait;

    public function getAboutCenter(): JsonResponse
    {
        $data = collect(setting('about-center'))->toArray() ?? '';
        $data['content'] = $data['content'] ?? '';
        $url = $data['video'] ?? '';
        $data['video'] = getYoutubeId($url);
        $data = [
            'data' => $data
        ];
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
        $tracks = is_string($track->tracks)
            ? json_decode($track->tracks, true)
            : $track->tracks;
        $data = [
            'data' => [
                'content' => $content,
                'tracks' => $tracks,
            ],
            'status' => 200
        ];
        return $this->setStatusCode(200)->respondWithArray($data);
    }
//    public function getCenterMechanism(): JsonResponse
//    {
//        $points = setting('center-mechanism');
//        $data = is_string($points->points)
//            ? json_decode($points->points, true)
//            :$points->points;
//        $data = [
//            'data' => [
//                'points' => $data,
//            ],
//            'status' => 200
//        ];
//        return $this->setStatusCode(200)->respondWithArray($data);
//    }
    public function getCenterMechanism(): JsonResponse
    {
        $points = setting('center-mechanism');

        // Decode points if it's a JSON string
        $data = is_string($points->points)
            ? json_decode($points->points, true)
            : $points->points;

        // Add index to each point's title
        $indexedPoints = [];
        if (is_array($data)) {
            foreach ($data as $index => $point) {
                $indexedPoints[] = [
                    'index' => $index + 1, // Add 1 to make it 1-based index
                    'title' => $point['title'] ?? '', // Ensure title is available
                ];
            }
        }

        // Prepare response data
        $responseData = [
            'data' => [
                'points' => $indexedPoints,
            ],
            'status' => 200,
        ];

        return $this->setStatusCode(200)->respondWithArray($responseData);
    }

    public function getContactsInfo(): JsonResponse
    {
        $data['data'] = collect(setting('app-contacts'))->toArray() ?? '';
        $logo = Setting::where('key', 'logo')->first();
        $icon = Setting::where('key', 'icon')->first();

        $data['logo'] = $logo ? $logo->getFirstMediaUrl('logo') : null;
        $data['icon'] = $icon ? $icon->getFirstMediaUrl('icon') : null;
        $data['keywords'] = Setting::where('key', 'keywords')->first()->value ?? '';
        $data['description'] = Setting::where('key', 'description')->first()->value ?? '';
        $data['twitter-section-id'] = Setting::where('key', 'twitter-section-id')->first()->value ?? '';

        $data['status'] = 200;
        return $this->setStatusCode(200)->respondWithArray($data);
    }
    public function getPrivacyPolicy(): JsonResponse
    {
        $data['data'] = collect(setting('privacy-policy'))->toArray() ?? '';
        $data['status'] = 200;
        return $this->setStatusCode(200)->respondWithArray($data);
    }
    public function getTermsAndConditions(): JsonResponse
    {
        $data['data'] = collect(setting('terms-and-conditions'))->toArray() ?? '';
        $data['status'] = 200;
        return $this->setStatusCode(200)->respondWithArray($data);
    }
    public function getDeleteAccount(): JsonResponse
    {
        $data['data'] = collect(setting('delete-account'))->toArray() ?? '';
        $data['status'] = 200;
        return $this->setStatusCode(200)->respondWithArray($data);
    }

    public function getYoutubeLive(): JsonResponse
    {

        $url = Setting::where('key', 'youtube-live')->first()->value ?? '';
        $data['data'] = getYoutubeId($url);
        $data['status'] = 200;
        return $this->setStatusCode(200)->respondWithArray($data);
    }
    public function getTelegramLive(): JsonResponse
    {
        $data['data'] = collect(setting('telegram-live'))->toArray() ?? '';
        $data['status'] = 200;
        return $this->setStatusCode(200)->respondWithArray($data);
    }
    public function getFacebookLive(): JsonResponse
    {
        $data['data'] = collect(setting('facebook-live'))->toArray() ?? '';
        $data['status'] = 200;
        return $this->setStatusCode(200)->respondWithArray($data);
    }
    public function getMixlrLive(): JsonResponse
    {
        $data['data'] = collect(setting('mixlr-live'))->toArray() ?? '';
        $data['status'] = 200;
        return $this->setStatusCode(200)->respondWithArray($data);
    }

    public function getHideSectionMembers(): JsonResponse
    {
        $data['data'] = Setting::where('key', 'hide-section-members')->first()->value ? 'true' : 'false';
        $data['status'] = 200;
        return $this->setStatusCode(200)->respondWithArray($data);
    }

}
