<?php

namespace App\Repositories\Concretes;

use App\Models\User;
use App\Models\User as Admin;
use App\Repositories\Contracts\AdminContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\PersonalAccessToken;

class AdminConcrete extends BaseConcrete implements AdminContract
{
    /**
     * AdminConcrete constructor.
     * @param Admin $model
     */
    public function __construct(Admin $model)
    {
        parent::__construct($model);
    }
    public function create(array $attributes = []): mixed
    {
        $attributes['type'] = 'admin';
        $attributes['is_active'] = 1;

        $record = parent::create($attributes);
        if (isset($attributes['avatar'])) {
            uploadImage('avatar', $attributes['avatar'], $record);
        }
        //$record->assignRole($request->input('roles'));
        $record->syncRoles([$attributes['roles']]);

        return $record;

    }

    public function update(Model $model, array $attributes = []): mixed
    {
        $record = parent::update($model, $attributes);
        if (isset($attributes['avatar'])) {
            uploadImage('avatar', $attributes['avatar'], $record);
        }
        if (isset($attributes['roles'])) {
            $record->syncRoles([$attributes['roles']]);
        }
        return $record;

    }

    public function updateProfile(array $attributes = [])
    {
        $user = auth()->user();
        $filtered = $this->cleanUpAttributes($attributes);
        $user->update($filtered);
        if (isset($attributes['avatar'])) {
            uploadImage('avatar', $attributes['avatar'], $user);
        }
        return $user;
    }

}
