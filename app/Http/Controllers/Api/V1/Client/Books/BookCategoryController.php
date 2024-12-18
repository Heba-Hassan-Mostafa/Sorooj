<?php

namespace App\Http\Controllers\Api\V1\Client\Books;

use App\Enum\CategoryTypeEnum;
use App\Http\Resources\Api\V1\Client\Books\BookCategoryResource;
use App\Repositories\Contracts\bookCategoryContract;
use App\Http\Controllers\Api\BaseApiController;

class BookCategoryController extends BaseApiController
{
    /**
     * CategoryController constructor.
     * @param BookCategoryContract $repository
     */

    protected int $limit = 0;
    protected int $page = 0;

    protected array $conditions = [
        'where' => [
            'type' => CategoryTypeEnum::BOOK,
            'parent_id' => null,
            'status' => 1
        ]];

    public function __construct(BookCategoryContract $repository)
    {
        request()->merge(['loadRelations' => 'subcategory','parent']);
        parent::__construct($repository, BookCategoryResource::class);
    }


}
