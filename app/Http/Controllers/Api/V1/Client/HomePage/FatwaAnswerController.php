<?php

namespace App\Http\Controllers\Api\V1\Client\HomePage;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\Api\V1\Client\FatwaAnswerResource;
use App\Models\FatwaAnswer;
use App\Models\FatwaQuestion;
use App\Repositories\Contracts\FatwaAnswerContract;

class FatwaAnswerController extends BaseApiController
{
    /**
     * CategoryController constructor.
     * @param FatwaAnswerContract $repository
     */

    public function __construct(FatwaAnswerContract $repository)
    {
        request()->merge(['loadRelations' => 'fatwaQuestion']);
        parent::__construct($repository, FatwaAnswerResource::class);
    }


    public function show($slug)
    {
        $question = FatwaQuestion::where('slug', $slug )->Active()->first();
        if (!$question) {
            return $this->respondWithError(__('Fatwa Question not found'));
        }
        $fatwaAnswer = FatwaAnswer::where('fatwa_question_id', $question->id)->Published()->first();
        if (!$fatwaAnswer) {
            return $this->respondWithError(__('No published Fatwa Answer found for this question'));
        }
        return $this->respondWithSuccess(__('Fatwa Answer details'), [
            'FatwaAnswer' => new FatwaAnswerResource($fatwaAnswer),
        ]);

    }
}
