<?php

namespace App\Repositories\Concretes;

use App\Models\FatwaQuestion;
use App\Repositories\Contracts\FatwaQuestionContract;
use Illuminate\Database\Eloquent\Model;

class FatwaQuestionConcrete extends BaseConcrete implements FatwaQuestionContract
{
    /**
     * SliderConcrete constructor.
     * @param FatwaQuestion $model
     */
    public function __construct(FatwaQuestion $model)
    {
        parent::__construct($model);
    }
    public function create(array $attributes = []): mixed
    {
        $attributes['user_id'] = auth()->id();
        $record = parent::create($attributes);
        return $record;

    }

    public function update(Model $model, array $attributes = []): mixed
    {
        $record = $model->fatwaAnswer()->create([
            'answer_content'        =>$attributes['answer_content'],
            'publish_date'          =>$attributes['publish_date'],
            'youtube_link'          =>$attributes['youtube_link'],
        ]);

        // store audio file
        if (isset($attributes['audio_file']) && $attributes['audio_file']->isValid()) {
            uploadImage('audio_file', $attributes['audio_file'], $record);
        }

        return $record;
    }

}
