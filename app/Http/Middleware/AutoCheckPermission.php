<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

class AutoCheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $routeName = $request->route()->getName(); // user.create
        $permission = Permission::whereRaw("FIND_IN_SET ('$routeName', routes)")->first();

        if ($permission) {
            // Get the current locale (language)
            $locale = app()->getLocale();

            // Log the current locale
            Log::info('Locale: ' . $locale);

            // If the permission name is stored as a JSON string, decode it into an array
            $permissionName = json_decode($permission->name, true); // Decode to array

            // Log the decoded permission name
            Log::info('Permission Name Structure:', ['permission_name' => $permissionName]);

            // Check if the permission name exists for the current locale
            $permissionNameForLocale = $permissionName[$locale] ?? null;

            // Log the specific permission for the current locale
            Log::info('Permission: ' . $permissionNameForLocale);

            // Debugging: Log all user permissions
            Log::info('User Permissions: ', ['permissions' => $request->user()->getAllPermissions()]);

//            if ($permissionNameForLocale && !$request->user()->can($permissionNameForLocale)) {
//                // Log the permission check failure
//                Log::warning('Permission Denied: User does not have the permission for ' . $permissionNameForLocale);
//                abort(403); // Forbidden if the user doesn't have permission
//            }
        } else {
            Log::warning('No permission found for route: ' . $routeName);
        }

        return $next($request);
    }

}
