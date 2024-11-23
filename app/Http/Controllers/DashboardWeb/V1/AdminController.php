<?php

namespace App\Http\Controllers\DashboardWeb\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Web\AdminRequest;
use App\Models\Role;
use App\Repositories\Contracts\AdminContract;
use Illuminate\Http\Request;
use App\Models\User as Admin;
class AdminController extends Controller
{

    protected AdminContract $repository;

    public function __construct(AdminContract $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = $this->repository->all()->where('type', 'admin')->whereNull('deleted_at');
        return view('admin.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::get(['id','name']);
        return view('admin.admins.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminRequest $request)
    {
        $this->repository->create($request->validated());
        return redirect()->route('admin.admins.index')->with('success', __('dashboard.added-successfully'));
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
        $admin = $this->repository->find($id);
        $roles = Role::get(['id','name']);
        $userRole = $admin->roles->pluck('id','name')->toArray();
        return view('admin.admins.edit', compact('admin','roles','userRole'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminRequest $request, Admin $admin)
    {
        $this->repository->update($admin,$request->validated());
        return redirect()->route('admin.admins.index')->with('success', __('dashboard.updated-successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        $this->repository->remove($admin);
        return redirect()->route('admin.admins.index')->with('success', __('dashboard.deleted-successfully'));
    }

    public function changeStatus(Request $request)
    {

        $this->repository->toggleField($request->id,'is_active');

        return response()->json(['success'=>'Status change successfully.']);

    }
}
