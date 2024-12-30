<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\Api\V1\Client\FavoriteResource;
use App\Models\Favorite;
use App\Repositories\Contracts\FavoriteContract;

class FavoriteController extends BaseApiController
{
    protected array $conditions = [
        'with' => ['favoriteable'],
        'where' => []
    ];

    public function __construct(FavoriteContract $repository)
    {
        parent::__construct($repository, FavoriteResource::class, 'favorite');

        // Dynamically set the user_id condition
        $this->conditions['where'] = ['user_id' => auth(activeGuard())?->id()];
    }
}
