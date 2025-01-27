<?php

namespace App\Http\Controllers\Api\V1\Client\Courses;

use App\Enum\CategoryTypeEnum;
use App\Http\Resources\Api\V1\Client\Courses\CourseCategoryResource;
use App\Models\Category;
use App\Repositories\Contracts\CourseCategoryContract;

use App\Http\Controllers\Api\BaseApiController;

class CategoryController extends BaseApiController
{
    /**
     * CategoryController constructor.
     * @param CourseCategoryContract $repository
     */

    protected int $limit = 0;
    protected int $page = 0;

    protected string $orderBy = 'order_position';
    protected string $orderDir = 'ASC';

    protected array $conditions = [
        'where' => [
            'type' => CategoryTypeEnum::COURSE,
            'parent_id' => null,
            'status' => 1
        ]];

    public function __construct(CourseCategoryContract $repository)
    {
        request()->merge(['loadRelations' => 'subcategory','parent','courses']);
        parent::__construct($repository, CourseCategoryResource::class);
    }


}
