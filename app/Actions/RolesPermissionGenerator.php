<?php

namespace App\Actions;

use Illuminate\Support\Str;
use App\Models\Permission;

class RolesPermissionGenerator
{
    public function handle(array $models, array $methods, string $guard_name, $additionalAdminPermissions = []): array
    {
        $permissions = [];
        foreach ($models as $model) {

            $permission = Permission::firstOrCreate(
                [
                    'slug' => Str::slug($model),
                    'guard_name' => 'web',
                ],
                [
                    'name' => [
                        'ar' => trans('permissions.responses.' . $model, [], 'ar'),
                        'en' => trans('permissions.responses.' . $model, [], 'en')
                    ],
                    'slug' => Str::slug($model),
                    'model' => $model,
                    'guard_name' => 'web',
                    'parent_id' => null,
                    'for_users' => $guard_name != 'admin' ? 1 : 0
                ]
            );

            foreach ($methods as $method) {
                $permissions[] = Permission::firstOrCreate([
                    'slug' => strtolower(Str::slug("$model $method")),
                    'parent_id' => $permission->id,
                    'guard_name' => 'web',
                ], [
                    'name' => [
                        'ar' => trans('permissions.responses.' . $method, [], 'ar') . ' ' . trans('permissions.responses.' . $model, [], 'ar'),
                        'en' => ucfirst(trans('permissions.responses.' . $model, [], 'en')) . ' ' . trans('permissions.responses.' . $method, [], 'en'),
                    ],
                    'slug' => strtolower(Str::slug("$model $method")),
                    'model' => $model,
                    'guard_name' => 'web',
                    'parent_id' => $permission->id,
                    'for_users' => $guard_name != 'admin' ? 1 : 0
                ]);
            }
        }

        if ($additionalAdminPermissions) {
            $parent = null;
            foreach ($additionalAdminPermissions as $additionalAdminPermission) {
                $splitedData = explode(' ', $additionalAdminPermission);
                $model = $splitedData[0];
                $method = $splitedData[1];
                $permissionMore = Permission::firstOrCreate([
                    'slug' => strtolower(Str::slug($additionalAdminPermission)),
                    'guard_name' => 'web',
                ], [
                    'name' => [
                        'ar' => trans('permissions.responses.' . $method, [], 'ar') . ' ' . trans('permissions.responses.' . $model, [], 'ar'),
                        'en' => ucfirst(trans('permissions.responses.' . $model, [], 'en')) . ' ' . trans('permissions.responses.' . $method, [], 'en'),
                    ],
                    'slug' => strtolower(Str::slug($additionalAdminPermission)),
                    'model' => $model,
                    'guard_name' => 'web',
                    'parent_id' => $parent,
                    'for_users' => $guard_name != 'admin' ? 1 : 0
                ]);

                if ($parent == null) {
                    $parent = $permissionMore->id;
                }
                $permissions[] = $permissionMore;
            }
        }

        return $permissions;
    }
}
