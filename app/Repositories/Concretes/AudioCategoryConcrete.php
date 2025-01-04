<?php

namespace App\Repositories\Concretes;

use App\Enum\CategoryTypeEnum;
use App\Models\Category;
use App\Repositories\Contracts\AudioCategoryContract;
use App\Repositories\Contracts\VideoCategoryContract;
use Illuminate\Database\Eloquent\Model;

class AudioCategoryConcrete extends BaseConcrete implements AudioCategoryContract
{
    /**
     * AdminConcrete constructor.
     * @param Category $model
     */

    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function getLivewireCategories()
    {
        return Category::whereNull('parent_id')->whereType(CategoryTypeEnum::AUDIO)->get();
    }

    public function create(array $attributes = []): mixed
    {
        $attributes["type"] = CategoryTypeEnum::AUDIO;

        $lastOrderPosition = Category::whereType(CategoryTypeEnum::AUDIO)->whereNull('parent_id')->max('order_position');
        $nextOrderPosition = $lastOrderPosition + 1;

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
