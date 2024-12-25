<?php

namespace App\Http\Controllers\DashboardWeb\V1\HomeSections;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use App\Repositories\Contracts\SubscriberContract;


class SubscriberController extends Controller
{
    protected SubscriberContract $repository;

    public function __construct(SubscriberContract $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subscribers = $this->repository->all();

        return view('admin.subscribers.index', compact('subscribers'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscriber $subscriber)
    {
        $this->repository->remove($subscriber);
        return redirect()->route('admin.subscribers.index')->with('success', __('dashboard.deleted-successfully'));
    }

}
