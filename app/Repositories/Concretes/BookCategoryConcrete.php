<?php

namespace App\Repositories\Concretes;

use App\Enum\CategoryTypeEnum;
use App\Models\Category;
use App\Repositories\Contracts\bookCategoryContract;
use Illuminate\Database\Eloquent\Model;

class BookCategoryConcrete extends BaseConcrete implements BookCategoryContract
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
        return Category::where('parent_id',null)->where('type',CategoryTypeEnum::BOOK)->get();
    }

    public function create(array $attributes = []): mixed
    {
        $attributes["type"] = CategoryTypeEnum::BOOK;
        $attributes["slug"] = $attributes["name"];

        $record = parent::create($attributes);

        return $record;

    }

    public function update(Model $model, array $attributes = []): mixed
    {

        $attributes["slug"] = $attributes["name"];

        $record = parent::update($model, $attributes);

        return $record;

    }

}
