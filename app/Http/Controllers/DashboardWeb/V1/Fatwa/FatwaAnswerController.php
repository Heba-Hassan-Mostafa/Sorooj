<?php

namespace App\Http\Controllers\DashboardWeb\V1\Fatwa;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Web\Fatwa\FatwaQuestionRequest;
use App\Models\FatwaAnswer;
use App\Repositories\Contracts\FatwaAnswerContract;


class FatwaAnswerController extends Controller
{
    protected FatwaAnswerContract $repository;

    public function __construct(FatwaAnswerContract $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $answers = $this->repository->all();

        return view('admin.fatwa.answers.index', compact('answers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $answer = $this->repository->find($id);
        return view('admin.fatwa.answers.edit',compact('answer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FatwaQuestionRequest $request, FatwaAnswer $answer)
    {
        $this->repository->update($answer,$request->validated());
        return redirect()->route('admin.fatwa.answers.index')->with('success', __('dashboard.updated-successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FatwaAnswer $answer)
    {
        $this->repository->remove($answer);
        return redirect()->route('admin.fatwa.questions.index')->with('success', __('dashboard.deleted-successfully'));
    }

    public function deleteAudioFile(FatwaAnswer $answer)
    {

        if ($answer->hasMedia('audio_file')) {
            $answer->getFirstMedia('audio_file')->delete();
            return response()->json(['success' => true, 'message' => 'audio deleted successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'audio file not found.'], 404);
    }

}
