<?php

namespace App\Repositories\Concretes;

use App\Models\User as Client;
use App\Repositories\Contracts\ClientContract;
use Illuminate\Database\Eloquent\Model;

class ClientConcrete extends BaseConcrete implements ClientContract
{
    /**
     * AdminConcrete constructor.
     * @param Client $model
     */
    public function __construct(Client $model)
    {
        parent::__construct($model);
    }
}
