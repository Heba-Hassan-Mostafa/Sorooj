<?php

namespace App\Repositories\Concretes;

use App\Models\FatwaAnswer;
use App\Repositories\Contracts\FatwaAnswerContract;
use Illuminate\Database\Eloquent\Model;

class FatwaAnswerConcrete extends BaseConcrete implements FatwaAnswerContract
{
    /**
     * SliderConcrete constructor.
     * @param FatwaAnswer $model
     */
    public function __construct(FatwaAnswer $model)
    {
        parent::__construct($model);
    }


    public function update(Model $model, array $attributes = []): mixed
    {
        $record = parent::update($model, $attributes);
        // store audio file
        if (isset($attributes['audio_file']) && $attributes['audio_file']->isValid()) {
            uploadImage('audio_file', $attributes['audio_file'], $record);
        }
        return $record;
    }

}
