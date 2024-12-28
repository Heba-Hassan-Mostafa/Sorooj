<?php

namespace App\Repositories\Concretes;

use App\Models\Favorite;
use App\Repositories\Contracts\FavoriteContract;

class FavoriteConcrete extends BaseConcrete implements FavoriteContract
{
    /**
     * AdminConcrete constructor.
     * @param Favorite $model
     */
    public function __construct(Favorite $model)
    {
        parent::__construct($model);
    }

}
