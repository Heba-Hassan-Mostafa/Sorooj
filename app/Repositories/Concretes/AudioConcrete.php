<?php

namespace App\Repositories\Concretes;

use App\Models\Audio;
use App\Repositories\Contracts\AudioContract;
use Illuminate\Database\Eloquent\Model;

class AudioConcrete extends BaseConcrete implements AudioContract
{
    /**
     * SliderConcrete constructor.
     * @param Audio $model
     */
    public function __construct(Audio $model)
    {
        parent::__construct($model);
    }

    public function getLivewireAudios()
    {
        return Audio::with(['category'])->get();
    }
    public function create(array $attributes = []): mixed
    {
        $attributes['audioable_type'] = 'Audio';
        $attributes['audioable_id'] = null;

        $lastOrderPosition = Audio::where('audioable_type','Audio')->max('order_position');
        $nextOrderPosition = $lastOrderPosition + 1;

        // Include the next order position in the attributes
        $attributes['order_position'] = $nextOrderPosition;

        $record = parent::create($attributes);

        if (isset($attributes['audio_file']) && $attributes['audio_file']->isValid()) {
            uploadImage('audio_file', $attributes['audio_file'], $record);
        }
        return $record;

    }

    public function update(Model $model, array $attributes = []): mixed
    {
        $record = parent::update($model, $attributes);

        if (isset($attributes['audio_file']) && $attributes['audio_file']->isValid()) {
            uploadImage('audio_file', $attributes['audio_file'], $record);
        }
        return $record;

    }

    public function suggestedAudios()
    {
        $randomAudios = Audio::with('media')->where('audioable_type','Audio')
            ->ActiveCategory()->Active()->Publish()->inRandomOrder()->paginate(3);

        return $randomAudios;

    }

}
