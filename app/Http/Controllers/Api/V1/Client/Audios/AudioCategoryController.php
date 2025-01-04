<?php

namespace App\Http\Controllers\Api\V1\Client\Audios;

use App\Enum\CategoryTypeEnum;
use App\Http\Resources\Api\V1\Client\Audios\AudioCategoryResource;
use App\Http\Controllers\Api\BaseApiController;
use App\Repositories\Contracts\AudioCategoryContract;

class AudioCategoryController extends BaseApiController
{
    /**
     * AudioCategoryController constructor.
     * @param AudioCategoryContract $repository
     */

    protected int $limit = 0;
    protected int $page = 0;

    protected array $conditions = [
        'where' => [
            'type' => CategoryTypeEnum::AUDIO,
            'parent_id' => null,
            'status' => 1
        ]];

    public function __construct(AudioCategoryContract $repository)
    {
        parent::__construct($repository, AudioCategoryResource::class);
    }


}
