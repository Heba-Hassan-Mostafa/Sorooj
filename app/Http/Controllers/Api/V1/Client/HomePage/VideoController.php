<?php

namespace App\Http\Controllers\Api\V1\Client\HomePage;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\Api\V1\Client\VideoResource;
use App\Models\Video;
use App\Repositories\Contracts\VideoContract;
use Illuminate\Http\JsonResponse;

class VideoController extends BaseApiController
{
    /**
     * CategoryController constructor.
     * @param VideoContract $repository
     */

    protected array $conditions = [
        'where' => [
            'status' => 1,
            'videoable_type' => 'Video',

        ]
    ];
    protected string $orderBy = 'order_position';

    public function __construct(VideoContract $repository)
    {
        parent::__construct($repository, VideoResource::class);
    }


}
