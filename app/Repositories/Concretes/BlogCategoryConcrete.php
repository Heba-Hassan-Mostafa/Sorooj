<?php

namespace App\Repositories\Concretes;

use App\Enum\CategoryTypeEnum;
use App\Models\Category;
use App\Repositories\Contracts\BlogCategoryContract;
use Illuminate\Database\Eloquent\Model;

class BlogCategoryConcrete extends BaseConcrete implements BlogCategoryContract
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
        return Category::where('parent_id',null)->where('type',CategoryTypeEnum::BLOG)->get();
    }

    public function create(array $attributes = []): mixed
    {
        $attributes["type"] = CategoryTypeEnum::BLOG;

        $lastOrderPosition = Category::whereType(CategoryTypeEnum::BLOG)->whereNull('parent_id')->max('order_position');
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
