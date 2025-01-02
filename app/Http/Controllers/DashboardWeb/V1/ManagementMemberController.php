<?php

namespace App\Http\Controllers\DashboardWeb\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Web\ManagementMemberRequest;
use App\Models\ManagementMember;
use App\Repositories\Contracts\ManagementMemberContract;
use Illuminate\Http\Request;
class ManagementMemberController extends Controller
{

    protected ManagementMemberContract $repository;

    public function __construct(ManagementMemberContract $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = $this->repository->all();
        return view('admin.members.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.members.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ManagementMemberRequest $request)
    {
        $this->repository->create($request->validated());
        return redirect()->route('admin.management-members.index')->with('success', __('dashboard.added-successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $member = $this->repository->find($id);
        return view('admin.members.edit', compact('member'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ManagementMemberRequest $request, ManagementMember $managementMember)
    {
        $this->repository->update($managementMember,$request->validated());
        return redirect()->route('admin.management-members.index')->with('success', __('dashboard.updated-successfully'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ManagementMember $managementMember)
    {
        $this->repository->remove($managementMember);
        return redirect()->route('admin.management-members.index')->with('success', __('dashboard.deleted-successfully'));
    }

    public function changeStatus(Request $request)
    {
        $this->repository->toggleField($request->id,'is_active');

        return response()->json(['success'=>'Status change successfully.']);

    }
}
