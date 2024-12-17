<?php

namespace App\Http\Controllers\DashboardWeb\V1\HomeSections;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Web\HomeSections\EventRequest;
use App\Models\UpcomingEvent;
use App\Repositories\Contracts\UpcomingEventContract;
use Carbon\Carbon;
use Illuminate\Http\Request;


class UpcomingEventController extends Controller
{
    protected UpcomingEventContract $repository;

    public function __construct(UpcomingEventContract $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = $this->repository->all()->where('event_date','>=',Carbon::now());

        return view('admin.events.index', compact('events'));
    }

    public function pastEvents()
    {
        $events = $this->repository->all()->where('event_date','<',Carbon::now());

        return view('admin.events.past_events',compact('events'));

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.events.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(EventRequest $request)
    {
        $this->repository->create($request->validated());
        return redirect()->route('admin.events.upcoming-events.index')->with('success', __('dashboard.added-successfully'));

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
         $event = $this->repository->find($id);
        return view('admin.events.show',compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $event = $this->repository->find($id);
        return view('admin.events.edit',compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventRequest $request, UpcomingEvent $upcomingEvent)
    {

        $this->repository->update($upcomingEvent,$request->validated());
        return redirect()->route('admin.events.upcoming-events.index')->with('success', __('dashboard.updated-successfully'));


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UpcomingEvent $upcomingEvent)
    {
        $this->repository->remove($upcomingEvent);
        return redirect()->route('admin.events.upcoming-events.index')->with('success', __('dashboard.deleted-successfully'));
    }

    public function changeStatus(Request $request)
    {
        //$this->repository->toggleField($request->id,'status');

        $event = UpcomingEvent::findOrFail($request->id);
        $newStatus = $request->status;

        $event->status = $newStatus;
        $event->save();

        return response()->json(['success' => 'Status changed successfully.']);

    }

}
