<?php

namespace App\Http\Controllers\Api\V1\Client\HomePage;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\Api\V1\Client\SliderResource;
use App\Repositories\Contracts\SliderContract;
use Illuminate\Http\JsonResponse;

class SliderController extends BaseApiController
{
    /**
     * CategoryController constructor.
     * @param SliderContract $repository
     */

    protected array $conditions = ['where' => ['status' => 1]];
    protected string $orderBy = 'order_position';
    protected int $limit = 0;
    protected int $page = 0;

    public function __construct(SliderContract $repository)
    {
        parent::__construct($repository, SliderResource::class);
    }


}
