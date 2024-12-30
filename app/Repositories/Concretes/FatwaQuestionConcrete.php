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

    public function update(Model $model, array $attributes = []): mixed
    {
        $record = $model->fatwaAnswer()->create([
            'answer_content'        =>$attributes['answer_content'],
            'publish_date'          =>$attributes['publish_date'],
            'youtube_link'          =>$attributes['youtube_link'],
        ]);

        // store audio file
        if (isset($attributes['audio_file']) && $attributes['audio_file']->isValid()) {
            uploadImage('audio_file', $attributes['audio_file'], $record);
        }

        return $record;
    }


    public function getMyQuestions()
    {
        $user = auth(activeGuard())?->user();
        if (!$user) {
            return response()->json(['message' => __('User not found')], 404);
        }
            $fatwaQuestions = $user->fatwaQuestions()->whereStatus(1)->whereHas('fatwaAnswer')->get();
        // Manually paginate the filtered courses
        $perPage = 10; // Adjust the per-page value as needed
        $currentPage = request('page', 1); // Default to the first page
        $paginatedQuestions = new \Illuminate\Pagination\LengthAwarePaginator(
            $fatwaQuestions->forPage($currentPage, $perPage),
            $fatwaQuestions->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return $paginatedQuestions;

    }

}
