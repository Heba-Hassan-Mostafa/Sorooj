<?php

namespace App\Http\Controllers\Api\V1\Client\HomePage;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\V1\Client\HomePage\FatwaQuestionRequest;
use App\Http\Resources\Api\V1\Client\FatwaQuestionResource;
use App\Models\FatwaQuestion;
use App\Repositories\Contracts\FatwaQuestionContract;
use Illuminate\Http\JsonResponse;

class FatwaQuestionController extends BaseApiController
{
    /**
     * CategoryController constructor.
     * @param FatwaQuestionContract $repository
     */

    protected array $conditions = ['where' => ['status' => 1]];

    public function __construct(FatwaQuestionContract $repository)
    {
        parent::__construct($repository, FatwaQuestionResource::class);
    }


    /**
     * Display the specified resource.
     *
     * @param FatwaQuestion $fatwaQuestion
     * @return JsonResponse
     */
    public function store(FatwaQuestionRequest $request): JsonResponse
    {
        $fatwaQuestion = $this->repository->create($request->validated());
        return $this->respondWithSuccess(__('Fatwa Question added successfully'), [
            'FatwaQuestion' => (new FatwaQuestionResource($fatwaQuestion)),
        ]);

    }

}