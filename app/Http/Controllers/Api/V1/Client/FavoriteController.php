<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\Api\V1\Client\FavoriteResource;
use App\Repositories\Contracts\FavoriteContract;

class FavoriteController extends BaseApiController
{
    /**
     * CategoryController constructor.
     * @param FavoriteContract $repository
     */

    protected array $conditions = [
       'with' => ['favoriteable']
    ];

    public function __construct(FavoriteContract $repository)
    {
        parent::__construct($repository, FavoriteResource::class,'favorite');
    }


}
