<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\V1\Client\ContactRequest;
use App\Http\Resources\Api\V1\Client\ContactResource;
use App\Models\Contact;
use App\Repositories\Contracts\ContactContract;
use Illuminate\Http\JsonResponse;

class ContactController extends BaseApiController
{
    /**
     * CategoryController constructor.
     * @param ContactContract $repository
     */


    public function __construct(ContactContract $repository)
    {
        parent::__construct($repository, ContactResource::class,'contact');
    }


    /**
     * Display the specified resource.
     *
     * @param Contact $Contact
     * @return JsonResponse
     */
    public function store(ContactRequest $request): JsonResponse
    {
        $Subscriber = $this->repository->create($request->validated());
        return $this->respondWithSuccess(__('Contact added successfully'), [
            'Contacts' => (new ContactResource($Subscriber)),
        ]);

    }
}
