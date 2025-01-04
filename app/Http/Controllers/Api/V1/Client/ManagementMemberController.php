<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\Api\V1\Client\FavoriteResource;
use App\Http\Resources\Api\V1\Client\ManagementMemberResource;
use App\Models\Favorite;
use App\Repositories\Contracts\FavoriteContract;
use App\Repositories\Contracts\ManagementMemberContract;

class ManagementMemberController extends BaseApiController
{
    protected array $conditions = ['where' => ['is_active' => 1]];
    protected string $orderBy = 'order_position';
    public function __construct(ManagementMemberContract $repository)
    {
        parent::__construct($repository, ManagementMemberResource::class, 'management_member');

    }
}
