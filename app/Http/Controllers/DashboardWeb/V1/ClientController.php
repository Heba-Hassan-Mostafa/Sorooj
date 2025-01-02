<?php

namespace App\Http\Controllers\DashboardWeb\V1;

use App\Enum\UserTypeEnum;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\ClientContract;
use Illuminate\Http\Request;
use App\Models\User as Client;
class ClientController extends Controller
{

    protected ClientContract $repository;

    public function __construct(ClientContract $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = $this->repository->all()->where('type', UserTypeEnum::CLIENT)->whereNull('deleted_at');
        return view('admin.clients.index', compact('clients'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $this->repository->remove($client);
        return redirect()->route('admin.clients.index')->with('success', __('dashboard.deleted-successfully'));
    }

    public function changeStatus(Request $request)
    {
        $this->repository->toggleField($request->id,'is_active');

        return response()->json(['success'=>'Status change successfully.']);

    }
}
