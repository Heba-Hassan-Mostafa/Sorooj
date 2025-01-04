<?php

namespace App\Providers;

use App\Classes\Scribe\FluentInterface;
use App\Models\Category;
use App\Models\User;
use App\Helpers\Setting;
use App\Repositories\Concretes\AdminConcrete;
use App\Repositories\Concretes\AudioCategoryConcrete;
use App\Repositories\Concretes\BlogCategoryConcrete;
use App\Repositories\Concretes\BookCategoryConcrete;
use App\Repositories\Concretes\ClientConcrete;
use App\Repositories\Concretes\CourseCategoryConcrete;
use App\Repositories\Concretes\VideoCategoryConcrete;
use App\Repositories\Contracts\AdminContract;
use App\Repositories\Contracts\AudioCategoryContract;
use App\Repositories\Contracts\BlogCategoryContract;
use App\Repositories\Contracts\BookCategoryContract;
use App\Repositories\Contracts\ClientContract;
use App\Repositories\Contracts\CourseCategoryContract;
use App\Repositories\Contracts\VideoCategoryContract;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;
use Knuckles\Camel\Extraction\ExtractedEndpointData;
use Knuckles\Scribe\Scribe;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AdminContract::class, function ($app) {
            return new AdminConcrete(new User);
        });
        $this->app->bind(ClientContract::class, function ($app) {
            return new ClientConcrete(new User);
        });
        $this->app->bind(CourseCategoryContract::class, function ($app) {
            return new CourseCategoryConcrete(new Category);
        });
        $this->app->bind(BookCategoryContract::class, function ($app) {
            return new BookCategoryConcrete(new Category);
        });
        $this->app->bind(BlogCategoryContract::class, function ($app) {
            return new BlogCategoryConcrete(new Category);
        });
        $this->app->bind(VideoCategoryContract::class, function ($app) {
            return new VideoCategoryConcrete(new Category);
        });
        $this->app->bind(AudioCategoryContract::class, function ($app) {
            return new AudioCategoryConcrete(new Category);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        # Scribe config
        $this->app->singleton('scribe_fluent', FluentInterface::class);
        # Matche laravel url schema
        Scribe::normalizeEndpointUrlUsing(fn ($url) => $url);
        Scribe::beforeResponseCall(function (Request $request, ExtractedEndpointData $endpointData) {
            # add api key to try it page
            $apiKey = json_decode(Storage::disk('local')->get('api_key.json'), true);
            $request->headers->set("Api-Key", $apiKey['api_key']);
            # Uncomment if you would like to add token to try it page
            //            $token = json_decode(Storage::disk('local')->get('scribe_token.json'), true);
            //            if (is_null($token)) {
            //                $token['token'] = User::query()->first()->createToken('codebase', ['scribe'],now()->addDays(30))->plainTextToken;
            //                Storage::disk('local')->put('scribe_token.json', json_encode($token));
            //            }
            //            $token = $token['token'];
            //            $request->headers->set("Authorization", "Bearer $token");
            //            $request->server->set("HTTP_AUTHORIZATION", "Bearer $token");
        });
        # Eloquent Uncomment if you would like to run app in strict mode
        //        Model::shouldBeStrict();
        # Telescope
        if ($this->app->isProduction()) {
            if (config('global.TELESCOPE_PRODUCTION', false)) {
                $this->registerTelescope();
            }
        } else {
            $this->registerTelescope();
        }

        Paginator::useBootstrap();
        Schema::defaultStringLength(191);
        //date_default_timezone_set(Config::get('app.timezone', 'Africa/Cairo'));

        # Enforce Morph Modela
        $modelFiles = Storage::disk('app')->files('Models');
        foreach ($modelFiles as $modelFile) {
            $model = str_replace('.php', '', $modelFile);
            $model = str_replace('Models/', '', $model);
            $modelClass = 'App\\Models\\' . str_replace('/', '\\', $model);
            Relation::enforceMorphMap([
                "$model" => "$modelClass"
            ]);
        }

        /**
         * Paginate a standard Laravel Collection.
         *
         * @param int $perPage
         * @param int $total
         * @param int $page
         * @param string $pageName
         * @return array
         */
        Collection::macro('customPaginate', function ($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });

        # setting helper class
        $this->app->singleton('setting', Setting::class);
    }

    private function registerTelescope(): void
    {
        $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
        $this->app->register(TelescopeServiceProvider::class);
    }
}
