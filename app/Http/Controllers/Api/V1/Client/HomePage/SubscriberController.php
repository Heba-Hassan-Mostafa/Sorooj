<?php

namespace App\Http\Controllers\Api\V1\Client\HomePage;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\V1\Client\HomePage\SubscriberRequest;
use App\Http\Resources\Api\V1\Client\SubscriberResource;
use App\Http\Resources\Api\V1\Client\UpcomingEventResource;
use App\Models\Subscriber;
use App\Repositories\Contracts\SubscriberContract;
use App\Repositories\Contracts\UpcomingEventContract;
use Illuminate\Http\JsonResponse;

class SubscriberController extends BaseApiController
{
    /**
     * CategoryController constructor.
     * @param SubscriberContract $repository
     */


    public function __construct(SubscriberContract $repository)
    {
        parent::__construct($repository, SubscriberResource::class);
    }


    /**
     * Display the specified resource.
     *
     * @param Subscriber $Subscriber
     * @return JsonResponse
     */
    public function store(SubscriberRequest $request): JsonResponse
    {
        $Subscriber = $this->repository->create($request->validated());
        return $this->respondWithSuccess(__('Subscriber added successfully'), [
            'Subscriber' => (new SubscriberResource($Subscriber)),
        ]);

    }




}
