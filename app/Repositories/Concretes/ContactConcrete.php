<?php

namespace App\Repositories\Concretes;

use App\Models\Contact;
use App\Repositories\Contracts\ContactContract;
use Illuminate\Database\Eloquent\Model;

class ContactConcrete extends BaseConcrete implements ContactContract
{
    /**
     * SliderConcrete constructor.
     * @param Contact $model
     */
    public function __construct(Contact $model)
    {
        parent::__construct($model);
    }
    public function create(array $attributes = []): mixed
    {
        $record = parent::create($attributes);
        return $record;

    }

}
