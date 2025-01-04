<?php

namespace App\Http\Controllers\DashboardWeb\V1;

use App\Models\Setting;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\SettingRequest;
use App\Repositories\Contracts\SettingContract;

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

        return view('admin.settings.about_center', compact('settings'));
    }
    public function websiteSettings()
    {
        $settings = Setting::all()->pluck('value', 'key');
        // Fetch the current logo URL if it exists
        $logo = Setting::where('key', 'logo')->first();
        $icon = Setting::where('key', 'icon')->first();

        $logoUrl = $logo ? $logo->getFirstMediaUrl('logo') : null;
        $iconUrl = $icon ? $icon->getFirstMediaUrl('icon') : null;

        return view('admin.settings.website_settings', compact('settings','logoUrl','iconUrl'));
    }
    public function live()
    {
        $settings = Setting::all()->pluck('value', 'key');

        return view('admin.settings.live', compact('settings'));
    }

    public function update(SettingRequest $request)
    {
       cache()->clear();
//        $setting = $this->repository->defaultUpdateOrCreate(
//            [
//                'key' => $request->key,
//            ],
//            [
//                'key' => $request->key,
//                'name' => $request->key,
//                'value' => $request->validated('value')
//            ]
//        );
//        # rebind the singleton instance
//        app()->singleton('setting', function ($app) {
//            cache()->forget('settings');
//            return new Setting();
//        });
        $settings = $request->except(['_token', '_method', 'logo', 'icon']);

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $setting = Setting::firstOrCreate(['key' => 'logo']);
            $setting->clearMediaCollection('logo'); // Clear old logo
            $setting->addMedia($request->file('logo'))->toMediaCollection('logo');
        }
        if ($request->hasFile('icon')) {
            $setting = Setting::firstOrCreate(['key' => 'icon']);
            $setting->clearMediaCollection('icon'); // Clear old logo
            $setting->addMedia($request->file('icon'))->toMediaCollection('icon');
        }
        return redirect()->back()->with('success', __('dashboard.updated-successfully'));


//        return $this->respondWithSuccess(__('setting added successfully'), [
//            'setting' => new SettingResource($setting),
//        ]);
    }
}
