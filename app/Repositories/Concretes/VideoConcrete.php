<?php

namespace App\Repositories\Concretes;

use App\Models\Slider;
use App\Models\Video;
use App\Repositories\Contracts\SliderContract;
use App\Repositories\Contracts\VideoContract;
use Illuminate\Database\Eloquent\Model;

class VideoConcrete extends BaseConcrete implements VideoContract
{
    /**
     * SliderConcrete constructor.
     * @param Video $model
     */
    public function __construct(Video $model)
    {
        parent::__construct($model);
    }
    public function create(array $attributes = []): mixed
    {

        $record = parent::create($attributes);
        return $record;

    }

    public function update(Model $model, array $attributes = []): mixed
    {
        $record = parent::update($model, $attributes);

        return $record;

    }

}
