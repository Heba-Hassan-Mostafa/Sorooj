<?php

namespace App\Http\Controllers\Api\V1\Client\Audios;

use App\Http\Resources\Api\V1\Client\Audios\AudioResource;
use App\Http\Controllers\Api\BaseApiController;
use App\Models\Audio;
use App\Repositories\Contracts\AudioContract;
use Illuminate\Http\JsonResponse;

class AudioLibraryController extends BaseApiController
{
    /**
     * AudioController constructor.
     * @param AudioContract $repository
     */

    protected array $conditions = ['where' => ['status' => 1 ,'audioable_type' => 'Audio']];
    protected string $orderBy = 'order_position';


    public function __construct(AudioContract $repository)
    {
        request()->merge(['loadRelations' => 'category']);
        parent::__construct($repository, AudioResource::class);
    }

    public function show($slug): JsonResponse
    {
        $audio = Audio::with(['category', 'media'])
            ->where('slug', $slug)
            ->firstOrFail();

        $audio->increment('view_count');
        return $this->respondWithSuccess(__('Audio details'), [
            'Audio' => (new AudioResource($audio)),
        ]);
    }

    public function suggestedAudios(): JsonResponse
    {
        $audio = $this->repository->suggestedAudios();
        return $this->respondWithSuccess(__('Suggested Audios'), [
            'suggested_audios' => AudioResource::collection($audio),
        ]);

    }
}
