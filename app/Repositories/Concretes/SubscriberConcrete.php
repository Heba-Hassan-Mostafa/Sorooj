<?php

namespace App\Repositories\Concretes;

use App\Models\FatwaAnswer;
use App\Models\Subscriber;
use App\Repositories\Contracts\SubscriberContract;
use Illuminate\Database\Eloquent\Model;

class SubscriberConcrete extends BaseConcrete implements SubscriberContract
{
    /**
     * SliderConcrete constructor.
     * @param Subscriber $model
     */
    public function __construct(Subscriber $model)
    {
        parent::__construct($model);
    }
    public function create(array $attributes = []): mixed
    {
        $record = parent::create($attributes);
        return $record;

    }

}
