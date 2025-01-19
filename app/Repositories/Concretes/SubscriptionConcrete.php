<?php

namespace App\Repositories\Concretes;

use App\Models\Subscription;
use App\Repositories\Contracts\SubscriptionContract;

class SubscriptionConcrete extends BaseConcrete implements SubscriptionContract
{
    /**
     * SliderConcrete constructor.
     * @param Subscription $model
     */
    public function __construct(Subscription $model)
    {
        parent::__construct($model);
    }
}
