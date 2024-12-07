<?php

namespace App\Repositories\Concretes;

use App\Models\UpcomingEvent;
use App\Repositories\Contracts\UpcomingEventContract;
use Illuminate\Database\Eloquent\Model;

class UpcomingEventConcrete extends BaseConcrete implements UpcomingEventContract
{
    /**
     * SliderConcrete constructor.
     * @param UpcomingEvent $model
     */
    public function __construct(UpcomingEvent $model)
    {
        parent::__construct($model);
    }
    public function create(array $attributes = []): mixed
    {

        $record = parent::create($attributes);
        if (isset($attributes['image'])) {
            uploadImage('image', $attributes['image'], $record);
        }

        return $record;

    }

    public function update(Model $model, array $attributes = []): mixed
    {
        $record = parent::update($model, $attributes);
        if (isset($attributes['image'])) {
            uploadImage('image', $attributes['image'], $record);
        }

        return $record;

    }

}
