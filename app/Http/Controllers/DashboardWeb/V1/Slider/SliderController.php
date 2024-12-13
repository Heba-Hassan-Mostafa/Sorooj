<?php

namespace App\Http\Controllers\DashboardWeb\V1\Slider;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Web\Slider\SliderRequest;
use App\Models\Slider;
use App\Repositories\Contracts\SliderContract;
use Illuminate\Http\Request;


class SliderController extends Controller
{
    protected SliderContract $repository;

    public function __construct(SliderContract $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = $this->repository->all();

        return view('admin.slider.index', compact('sliders'));
    }

    /**
     * Display a listing of the resource.
     */
    public function livewire_index()
    {
        $sliders = $this->repository->getLivewireSliders();
        return view('admin.slider.livewire_index',compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.slider.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(SliderRequest $request)
    {
        $this->repository->create($request->validated());
        return redirect()->route('admin.slider.slider.index')->with('success', __('dashboard.added-successfully'));

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
         $slider = $this->repository->find($id);
        return view('admin.slider.show',compact('slider'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $slider = $this->repository->find($id);
        return view('admin.slider.edit',compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SliderRequest $request, Slider $slider)
    {

        $this->repository->update($slider,$request->validated());
        return redirect()->route('admin.slider.slider.index')->with('success', __('dashboard.updated-successfully'));


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        $this->repository->remove($slider);
        return redirect()->route('admin.slider.slider.index')->with('success', __('dashboard.deleted-successfully'));
    }

    public function changeStatus(Request $request)
    {
        $this->repository->toggleField($request->id,'status');

        return response()->json(['success'=>'Status change successfully.']);

    }

}
