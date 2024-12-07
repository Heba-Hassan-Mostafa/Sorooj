<?php

namespace App\Http\Controllers\Api\V1\Client\HomePage;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\Api\V1\Client\UpcomingEventResource;
use App\Repositories\Contracts\UpcomingEventContract;
use Illuminate\Http\JsonResponse;

class UpcomingEventController extends BaseApiController
{
    /**
     * CategoryController constructor.
     * @param UpcomingEventContract $repository
     */

    protected array $conditions = [
        'where' => [
            'is_active' => 1
        ]
    ];
    protected int $limit = 0;
    protected int $page = 0;

    public function __construct(UpcomingEventContract $repository)
    {
        parent::__construct($repository, UpcomingEventResource::class);
    }


}
