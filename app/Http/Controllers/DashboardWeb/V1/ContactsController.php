<?php

namespace App\Http\Controllers\DashboardWeb\V1;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\ContactContract;
use Illuminate\Http\Request;
use App\Models\Contact;
class ContactsController extends Controller
{

    protected ContactContract $repository;

    public function __construct(ContactContract $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = $this->repository->all();
        return view('admin.contacts.index', compact('contacts'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $this->repository->remove($contact);
        return redirect()->route('admin.contacts.index')->with('success', __('dashboard.deleted-successfully'));
    }

}
