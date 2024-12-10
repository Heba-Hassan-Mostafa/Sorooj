<?php

namespace App\Repositories\Concretes;

use App\Models\FatwaAnswer;
use App\Models\FatwaQuestion;
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
    public function create(array $attributes = []): mixed
    {
        $attributes['user_id'] = auth()->id();
        $record = parent::create($attributes);
        return $record;

    }
//
//    public function update(Model $model, array $attributes = []): mixed
//    {
//        $record = parent::update($model, $attributes);
//        return $record;
//    }

}
