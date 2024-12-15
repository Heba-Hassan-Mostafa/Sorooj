<?php

namespace App\Http\Controllers\Api\V1\Client\Blogs;

use App\Enum\CategoryTypeEnum;
use App\Http\Resources\Api\V1\Client\Blogs\BlogCategoryResource;
use App\Repositories\Contracts\BlogCategoryContract;
use App\Http\Controllers\Api\BaseApiController;

class BlogCategoryController extends BaseApiController
{
    /**
     * CategoryController constructor.
     * @param BlogCategoryContract $repository
     */

    protected int $limit = 0;
    protected int $page = 0;

    protected array $conditions = [
        'where' => [
            'type' => CategoryTypeEnum::BLOG,
            'parent_id' => null,
            'status' => 1
        ]];

    public function __construct(BlogCategoryContract $repository)
    {
        parent::__construct($repository, BlogCategoryResource::class);
    }


}
