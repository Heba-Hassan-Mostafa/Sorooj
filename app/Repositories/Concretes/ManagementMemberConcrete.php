<?php

namespace App\Repositories\Concretes;

use App\Models\ManagementMember;
use App\Repositories\Contracts\ManagementMemberContract;
use Illuminate\Database\Eloquent\Model;

class ManagementMemberConcrete extends BaseConcrete implements ManagementMemberContract
{
    /**
     * AdminConcrete constructor.
     * @param ManagementMember $model
     */
    public function __construct(ManagementMember $model)
    {
        parent::__construct($model);
    }
    public function create(array $attributes = []): mixed
    {
        $record = parent::create($attributes);

        if (isset($attributes['avatar'])) {
            uploadImage('avatar', $attributes['avatar'], $record);
        }
        return $record;

    }

    public function update(Model $model, array $attributes = []): mixed
    {
        $record = parent::update($model, $attributes);
        if (isset($attributes['avatar'])) {
            uploadImage('avatar', $attributes['avatar'], $record);
        }
        return $record;

    }

}
