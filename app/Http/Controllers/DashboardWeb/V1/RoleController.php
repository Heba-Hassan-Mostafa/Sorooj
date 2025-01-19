<?php

namespace App\Http\Controllers\DashboardWeb\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\RoleRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Repositories\Contracts\RoleContract;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    protected RoleContract $repository;

    public function __construct(RoleContract $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = $this->repository->all();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $permissions = Permission::where('flag',1)->get()->groupBy('model')->map(function ($controls, $modelName) {
            return [
                'name' => __("permissions.responses." . $modelName),
                'controls' => $controls->map(function ($control) {
                    return [
                        "name" => $control->name,
                        "key" => explode(" ", $control->name)[0],
                        "id" => $control->id,

                    ];
                })->all(),
            ];
        })->values();

        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
//        $names = [];
//        foreach (app_languages() as $key => $one) {
//            $names[$key] = $request->input("name_{$key}");
//        }

        $role = $this->repository->create([
            'name' => $request->name,
            'slug' => $request->input("name"),
        ]);

        // Handle permissions
        $requestPermissions = $request->input('role_permissions', []);
        $requestPermissions = array_filter($requestPermissions); // Remove empty values

        if (!empty($requestPermissions)) {
            // Check if all permissions exist
            $validPermissions = Permission::whereIn('id', $requestPermissions)
                ->where('guard_name', 'web')
                ->pluck('id')
                ->toArray();

            if (count($validPermissions) > 0) {
                $role->syncPermissions($validPermissions);
            } else {
                return redirect()->back()->withErrors(['permissions' => __('dashboard.roles.invalid-permissions-selected')]);
            }
        }


        // Flash success message
        return redirect()->route('admin.roles.index')->with('success', __('dashboard.roles.role-added-successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $role->load('permissions');
        return view('admin.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Find the role by ID
        $role = $this->repository->find($id);
        if (!$role) {
            return redirect()->back()->withErrors(['role' => __('dashboard.roles.role-not-found')]);
        }

        // Fetch the permissions, grouping them by model
        $permissions = Permission::where('flag', 1)->get()->groupBy('model')->map(function ($controls, $modelName) {
            return [
                'name' => __("permissions.responses." . $modelName),
                'controls' => $controls->map(function ($control) {
                    return [
                        'name' => $control->name,
                        'key' => explode(" ", $control->name)[0],
                        'id' => $control->id,
                    ];
                })->all(),
            ];
        })->values();

        // Return the edit view with role and permissions
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, $id)
    {
        $role = $this->repository->find($id);
        if (!$role) {
            return redirect()->back()->withErrors(['role' => __('dashboard.roles.role-not-found')]);
        }

//        $names = [];
//        foreach (app_languages() as $key => $one) {
//            $names[$key] = $request->input("name_{$key}");
//        }

        $role->update([
            'name' => $request->name,
            'slug' => $request->input("name"),
        ]);

        // Handle permissions
        $requestPermissions = $request->input('role_permissions', []);
        $requestPermissions = array_filter($requestPermissions); // Remove empty values

        if (!empty($requestPermissions)) {
            $validPermissions = Permission::whereIn('id', $requestPermissions)
                ->where('guard_name', 'web')
                ->pluck('id')
                ->toArray();

            if (count($validPermissions) > 0) {
                $role->syncPermissions($validPermissions);
            } else {
                return redirect()->back()->withErrors(['permissions' => __('dashboard.roles.invalid-permissions-selected')]);
            }
        }

        return redirect()->route('admin.roles.index')->with('success', __('dashboard.roles.role-updated-successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $this->repository->remove($role);
        return redirect()->route('admin.roles.index')->with('success', __('dashboard.roles.role-deleted-successfully'));
    }

    public function changeStatus(Request $request)
    {

        $this->repository->toggleField($request->id,'status');

        return response()->json(['success'=>'Status change successfully.']);

    }
}
