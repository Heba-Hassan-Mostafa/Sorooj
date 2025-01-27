<?php

namespace App\Http\Controllers\Api\V1\Client\Videos;

use App\Enum\CategoryTypeEnum;
use App\Http\Resources\Api\V1\Client\Videos\VideoCategoryResource;
use App\Http\Controllers\Api\BaseApiController;
use App\Repositories\Contracts\VideoCategoryContract;

class VideoCategoryController extends BaseApiController
{
    /**
     * CategoryController constructor.
     * @param VideoCategoryContract $repository
     */

    protected int $limit = 0;
    protected int $page = 0;

    protected string $orderBy = 'order_position';

    protected string $orderDir = 'ASC';

    protected array $conditions = [
        'where' => [
            'type' => CategoryTypeEnum::VIDEO,
            'parent_id' => null,
            'status' => 1
        ]];

    public function __construct(VideoCategoryContract $repository)
    {
        parent::__construct($repository, VideoCategoryResource::class);
    }


}
