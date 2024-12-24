<?php

namespace App\Http\Controllers\DashboardWeb\V1\Fatwa;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Web\Fatwa\FatwaQuestionRequest;
use App\Models\FatwaQuestion;
use App\Repositories\Contracts\FatwaQuestionContract;
use Illuminate\Http\Request;


class FatwaQuestionController extends Controller
{
    protected FatwaQuestionContract $repository;

    public function __construct(FatwaQuestionContract $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = $this->repository->all();

        return view('admin.fatwa.questions.index', compact('questions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $question = $this->repository->find($id);
        return view('admin.fatwa.questions.edit',compact('question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FatwaQuestionRequest $request, FatwaQuestion $question)
    {
        $this->repository->update($question,$request->validated());
        return redirect()->route('admin.fatwa.questions.index')->with('success', __('dashboard.updated-successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FatwaQuestion $question)
    {
        $this->repository->remove($question);
        return redirect()->route('admin.fatwa.questions.index')->with('success', __('dashboard.deleted-successfully'));
    }

    public function changeStatus(Request $request)
    {
        $question = FatwaQuestion::findOrFail($request->id);
        $newStatus = $request->status;

        $question->status = $newStatus;
        $question->save();

        return response()->json(['success' => 'Status changed successfully.']);

    }

}
