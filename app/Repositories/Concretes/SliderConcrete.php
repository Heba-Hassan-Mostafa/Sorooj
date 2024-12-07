<?php

namespace App\Repositories\Concretes;

use App\Models\Slider;
use App\Repositories\Contracts\SliderContract;
use Illuminate\Database\Eloquent\Model;

class SliderConcrete extends BaseConcrete implements SliderContract
{
    /**
     * SliderConcrete constructor.
     * @param Slider $model
     */
    public function __construct(Slider $model)
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
