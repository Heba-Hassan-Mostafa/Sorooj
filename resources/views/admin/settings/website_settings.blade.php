@extends('admin.layouts.master')
@section('title')
    {{ trans('dashboard.sidebar.website-settings') }}
@endsection
@section('content')
    <h4 class="py-3 mb-4">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/ </span>
        </a>
        <a href="{{ route('admin.settings.websiteSettings') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.sidebar.website-settings') }}</span>
        </a>
    </h4>
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="copyright" class="form-label">{{ trans('dashboard.settings.copyright') }}</label>
                            <input type="text" name="copyright" value="{{ $settings['copyright'] ?? '' }}" class="form-control" />
                            @error('copyright')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="hide-section-members" class="form-label">{{ trans('dashboard.settings.hide-section-members') }}</label>
                            <select name="hide-section-members" id="hide-section-members" class="form-select">
                                <option value="1" {{ isset($settings['hide-section-members']) && $settings['hide-section-members'] == 1 ? 'selected' : '' }}>
                                    {{ trans('dashboard.active') }}
                                </option>
                                <option value="0" {{ isset($settings['hide-section-members']) && $settings['hide-section-members'] == 0 ? 'selected' : '' }}>
                                    {{ trans('dashboard.inactive') }}
                                </option>
                            </select>
                            @error('hide-section-members')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="logo" class="form-label">{{ trans('dashboard.settings.logo') }}</label>
                            <input type="file" name="logo" id="logo" class="form-control" />
                            @if ($logoUrl)
                                <div class="mb-3">
                                    <div>
                                        <img src="{{ $logoUrl }}" alt="Logo" style="max-height: 100px;">
                                    </div>
                                </div>
                            @endif
                            @error('logo')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="icon" class="form-label">{{ trans('dashboard.settings.icon') }}</label>
                            <input type="file" name="icon" id="icon" class="form-control" />
                            @if ($iconUrl)
                                <div class="mb-3">
                                    <div>
                                        <img src="{{ $iconUrl }}" alt="icon" style="max-height: 100px;">
                                    </div>
                                </div>
                            @endif
                            @error('icon')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label for="keywords" class="form-label">{{ trans('dashboard.settings.keywords') }}</label>
                            <input type="text" name="keywords" value="{{ $settings['keywords'] ?? '' }}" class="form-control" />
                            @error('keywords')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="description" class="form-label">{{ trans('dashboard.settings.description') }}</label>
                        <textarea name="description" class="form-control" cols="30" rows="10">{!! $settings['description'] ?? '' !!}</textarea>
                        @error('description')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-12 mb-3">
                        <label for="privacy-policy" class="form-label">{{ trans('dashboard.settings.privacy-policy') }}</label>
                        <textarea name="privacy-policy" class="form-control" cols="30" rows="10">{!! $settings['privacy-policy'] ?? '' !!}</textarea>
                        @error('privacy-policy')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-12 mb-3">
                        <label for="terms-and-conditions" class="form-label">{{ trans('dashboard.settings.terms-and-conditions') }}</label>
                        <textarea name="terms-and-conditions" class="form-control" cols="30" rows="10">{!! $settings['terms-and-conditions'] ?? '' !!}</textarea>
                        @error('terms-and-conditions')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-12 mb-3">
                        <label for="delete-account" class="form-label">{{ trans('dashboard.settings.delete-account') }}</label>
                        <textarea name="delete-account" class="form-control" cols="30" rows="10">{!! $settings['delete-account'] ?? '' !!}</textarea>
                        @error('delete-account')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">{{ trans('dashboard.save') }} </button>
                </form>
            </div>
        </div>
    </div>
@endsection
