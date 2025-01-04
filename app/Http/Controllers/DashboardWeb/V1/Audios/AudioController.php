<?php

namespace App\Http\Controllers\DashboardWeb\V1\Audios;

use App\Enum\CategoryTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Web\Audios\AudioRequest;
use App\Models\Audio;
use App\Models\Category;
use App\Repositories\Contracts\AudioContract;
use Illuminate\Http\Request;

class AudioController extends Controller
{
    protected AudioContract $repository;

    public function __construct(AudioContract $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $audios = $this->repository->all()->where('audioable_type','Audio')->whereNotNull('category_id');

        return view('admin.audios.audios.index', compact('audios'));
    }

    /**
     * Display a listing of the resource.
     */
    public function livewire_index()
    {
        $audios = $this->repository->getLivewireAudios();
        return view('admin.audios.audios.livewire_index',compact('audios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('type',CategoryTypeEnum::AUDIO)->get();
        return view('admin.audios.audios.create',compact('categories'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(AudioRequest $request)
    {
        $this->repository->create($request->validated());
        return redirect()->route('admin.audios.audios.index')->with('success', __('dashboard.added-successfully'));

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
         $audio = $this->repository->find($id);
        return view('admin.audios.audios.show',compact('video'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categories = Category::where('type',CategoryTypeEnum::AUDIO)->get();
        $audio = $this->repository->find($id);
        return view('admin.audios.audios.edit',compact('categories','audio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AudioRequest $request, Audio $audio)
    {
        $this->repository->update($audio,$request->validated());
        return redirect()->route('admin.audios.audios.index')->with('success', __('dashboard.updated-successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Audio $audio)
    {
        $this->repository->remove($audio);
        return redirect()->route('admin.audios.audios.index')->with('success', __('dashboard.deleted-successfully'));
    }

    public function changeStatus(Request $request)
    {
        $this->repository->toggleField($request->id,'status');

        return response()->json(['success'=>'Status change successfully.']);

    }

    public function deleteAudioFile(Audio $audio)
    {

        if ($audio->hasMedia('audio_file')) {
            $audio->getFirstMedia('audio_file')->delete();
            return response()->json(['success' => true, 'message' => 'audio deleted successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'audio file not found.'], 404);
    }
}
