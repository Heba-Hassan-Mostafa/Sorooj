<?php

namespace Database\Seeders;

use App\Actions\RolesPermissionGenerator;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    protected static mixed $abilities;
    protected static mixed $models;
    protected static mixed $permissions;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        DB::table('roles')->truncate();
//        DB::table('permissions')->truncate();
//        DB::table('role_has_permissions')->truncate();
//        DB::table('model_has_roles')->truncate();
//        DB::table('model_has_permissions')->truncate();


        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->defaultPermissions();
        $this->syncAdminRole();
        $this->syncClientRole();
        $this->syncProviderRole();
    }

    public function defaultPermissions(): void
    {
        $this->adminRole(new RolesPermissionGenerator());
        $this->clientRole(new RolesPermissionGenerator());
        $this->providerRole(new RolesPermissionGenerator());
    }

    private function adminRole($rolesPermissionGenerator): void
    {
        # Models
        $adminModels = [
            'roles', 'admins','course_categories','courses','book_categories','books',
            'blog_categories', 'blogs','video_categories','videos', 'audio_categories','audios',
           'sliders','upcoming_events','management_members',
        ];
        # Default Methods
        $methods = ['index', 'create', 'edit', 'delete'];
        # Additional Permissions
        $additionalAdminPermissions = [
            'clients index', 'clients delete','course_comments index','course_comments delete','book_comments index','book_comments delete',
            'blog_comments index','blog_comments delete','subscribers index','subscribers delete',
            'fatwa_questions index', 'fatwa_questions delete', 'fatwa_questions reply','fatwa_answers index',
            'fatwa_answers edit', 'fatwa_answers delete','live index','live edit',
            'contacts index', 'contacts reply','setting_contacts edit','setting_aboutCenter edit',
            'settings_websiteSettings edit'
        ];
        # Generate
        $adminRole = Role::firstOrCreate([
            'name' => [
                'ar' => __('permissions.responses.roles-models.admin', [], 'ar'),
                'en' => __('permissions.responses.roles-models.admin', [], 'en')
            ],
            'guard_name' => 'web',
            'slug' => 'admin'
        ]);
        $adminRole->syncPermissions(
            $rolesPermissionGenerator->handle(
                $adminModels,
                $methods,
                'admin',
                additionalAdminPermissions: $additionalAdminPermissions
            )
        );
    }

    private function clientRole($rolesPermissionGenerator): void
    {
        # Models
        $clientModels = [];
        # Default Methods
        $methods = ['index', 'create', 'edit', 'delete', 'show', 'activate'];
        # Additional Permissions
        $additionalClientPermissions = [];
        # Generate
        $clientRole = Role::firstOrCreate([
            'name' => [
                'ar' => __('permissions.responses.roles-models.client', [], 'ar'),
                'en' => __('permissions.responses.roles-models.client', [], 'en')
            ],
            'guard_name' => 'web',
            'slug' => 'client'
        ]);
        $clientRole->syncPermissions(
            $rolesPermissionGenerator->handle(
                $clientModels,
                $methods,
                'client',
                additionalAdminPermissions: $additionalClientPermissions
            )
        );
    }

    private function providerRole($rolesPermissionGenerator): void
    {
        # Models
        $providerModels = [];
        # Default Methods
        $methods = ['index', 'create', 'edit', 'delete', 'show', 'activate'];
        # Additional Permissions
        $additionalProviderPermissions = [];
        # Generate
        $providerRole = Role::firstOrCreate([
            'name' => [
                'ar' => __('permissions.responses.roles-models.provider', [], 'ar'),
                'en' => __('permissions.responses.roles-models.provider', [], 'en')
            ],
            'guard_name' => 'web',
            'slug' => 'provider'
        ]);
        $providerRole->syncPermissions(
            $rolesPermissionGenerator->handle(
                $providerModels,
                $methods,
                'provider',
                additionalAdminPermissions: $additionalProviderPermissions
            )
        );
    }

    private function syncAdminRole(): void
    {
        User::whereRelation('roles', 'slug', 'LIKE', 'admin')
            ->get()
            ->each(function ($user) {
                $user->syncRoles([1]);
            });
    }

    private function syncClientRole(): void
    {
        User::whereRelation('roles', 'slug', 'LIKE', 'client')
            ->get()
            ->each(function ($user) {
                $user->syncRoles([2]);
            });;
    }

    private function syncProviderRole(): void
    {
        User::whereRelation('roles', 'slug', 'LIKE', 'provider')
            ->get()
            ->each(function ($user) {
                $user->syncRoles([3]);
            });
    }
}
