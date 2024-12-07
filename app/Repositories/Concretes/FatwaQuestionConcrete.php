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
//
//    public function update(Model $model, array $attributes = []): mixed
//    {
//        $record = parent::update($model, $attributes);
//        return $record;
//    }

}
