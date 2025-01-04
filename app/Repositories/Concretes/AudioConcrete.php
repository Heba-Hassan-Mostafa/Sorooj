<?php

namespace App\Repositories\Concretes;

use App\Models\Video;
use App\Repositories\Contracts\AudioContract;
use Illuminate\Database\Eloquent\Model;

class AudioConcrete extends BaseConcrete implements AudioContract
{
    /**
     * SliderConcrete constructor.
     * @param Video $model
     */
    public function __construct(Video $model)
    {
        parent::__construct($model);
    }

    public function getLivewireVideos()
    {
        return Video::with(['category'])->get();
    }
    public function create(array $attributes = []): mixed
    {
        $attributes['videoable_type'] = 'Video';
        $attributes['videoable_id'] = null;

        $lastOrderPosition = Video::where('videoable_type','Video')->max('order_position');
        $nextOrderPosition = $lastOrderPosition + 1;

        // Include the next order position in the attributes
        $attributes['order_position'] = $nextOrderPosition;

        $record = parent::create($attributes);
        return $record;

    }

    public function update(Model $model, array $attributes = []): mixed
    {
        $record = parent::update($model, $attributes);

        return $record;

    }

}
