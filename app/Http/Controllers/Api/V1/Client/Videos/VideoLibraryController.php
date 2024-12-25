<?php

namespace App\Http\Controllers\Api\V1\Client\Videos;

use App\Http\Resources\Api\V1\Client\Videos\VideoResource;
use App\Http\Controllers\Api\BaseApiController;
use App\Repositories\Contracts\VideoContract;

class VideoLibraryController extends BaseApiController
{
    /**
     * CategoryController constructor.
     * @param VideoContract $repository
     */

    protected array $conditions = ['where' => ['status' => 1 ,'videoable_type' => 'Video']];
    protected string $orderBy = 'order_position';


    public function __construct(VideoContract $repository)
    {
        request()->merge(['loadRelations' => 'category']);
        parent::__construct($repository, VideoResource::class);
    }

}
