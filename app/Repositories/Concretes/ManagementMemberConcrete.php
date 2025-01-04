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
    public function getLivewireMembers()
    {
        return ManagementMember::get();
    }
    public function create(array $attributes = []): mixed
    {
        $lastOrderPosition = ManagementMember::max('order_position');
        $nextOrderPosition = $lastOrderPosition + 1;

        // Include the next order position in the attributes
        $attributes['order_position'] = $nextOrderPosition;
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
