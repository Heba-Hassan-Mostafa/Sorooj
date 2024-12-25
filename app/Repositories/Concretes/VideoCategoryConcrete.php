<?php

namespace App\Repositories\Concretes;

use App\Enum\CategoryTypeEnum;
use App\Models\Category;
use App\Repositories\Contracts\VideoCategoryContract;
use Illuminate\Database\Eloquent\Model;

class VideoCategoryConcrete extends BaseConcrete implements VideoCategoryContract
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
        return Category::whereNull('parent_id')->whereType(CategoryTypeEnum::VIDEO)->get();
    }

    public function create(array $attributes = []): mixed
    {
        $attributes["type"] = CategoryTypeEnum::VIDEO;

        $lastOrderPosition = Category::whereType(CategoryTypeEnum::VIDEO)->whereNull('parent_id')->max('order_position');
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
