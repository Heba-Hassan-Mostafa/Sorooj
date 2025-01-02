<?php

namespace App\Http\Controllers\DashboardWeb\V1;

use App\Models\Setting;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\SettingRequest;
use App\Http\Resources\Api\Setting\SettingResource;
use App\Repositories\Contracts\SettingContract;
use Illuminate\Http\JsonResponse;

class SettingController extends Controller
{
    protected SettingContract $repository;

    public function __construct(SettingContract $repository)
    {
        $this->repository = $repository;

    }

    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }
    public function aboutCenter()
    {
        $settings = Setting::all()->pluck('value', 'key');
       // $settings['center-mechanism'] = json_decode($settings['center-mechanism'], true);

        return view('admin.settings.about_center', compact('settings'));
    }

    /**
     * @param SettingRequest $request
     * @return JsonResponse
     */
    public function store(SettingRequest $request): JsonResponse
    {
        cache()->clear();
        $setting = $this->repository->defaultUpdateOrCreate(
            [
                'key' => $request->key,
            ],
            [
                'key' => $request->key,
                'name' => $request->key,
                'value' => $request->validated('value')
            ]
        );
        # rebind the singleton instance
        app()->singleton('setting', function ($app) {
            cache()->forget('settings');
            return new Setting();
        });
        return $this->respondWithSuccess(__('setting added successfully'), [
            'setting' => new SettingResource($setting),
        ]);
    }
}
