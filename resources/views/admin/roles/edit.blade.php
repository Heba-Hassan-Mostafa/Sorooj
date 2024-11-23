@extends('admin.layouts.master')

@section('title')
    {{ trans('dashboard.roles.edit-role') }}
@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/ </span>
        </a>
        <a href="{{ route('admin.roles.index') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.sidebar.roles') }}/</span>
        </a>
        {{ trans('dashboard.roles.edit-role') }}
    </h4>

    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-body">
                <form class="form-horizontal" action="{{ route('admin.roles.update', $role->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="card-header">
                            <h5 class="card-title bold brownColor">{{ trans('dashboard.roles.role-name') }}</h5>
                            <ul class="nav nav-tabs" role="tablist">
                                @foreach (app_languages() as $key => $one)
                                    <li class="nav-item">
                                        <a class="mainColor nav-link {{ $key == app()->getLocale() ? 'active' : '' }}" id="tab-{{ $key }}-tab" data-bs-toggle="tab"
                                           href="#tab-{{ $key }}" role="tab">
                                            {{ $one['native'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="card-body table-responsive">
                            <fieldset>
                                <div class="tab-content">
                                    @foreach (app_languages() as $key => $one)
                                        <div class="tab-pane fade {{ $key == app()->getLocale() ? 'show active' : '' }}" id="tab-{{ $key }}" role="tabpanel">
                                            <div class="form-body">
                                                <div class="form-group row">
                                                    <input type="text" name="name_{{ $key }}" class="form-control" placeholder="{{ trans('dashboard.roles.role-name') }}" value="{{ old('name_' . $key, $role->getTranslation('name', $key)) }}">
                                                    @error('name_' . $key)
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <hr />
                                <div class="form-group">
                                    <div class="row align-items-center">
                                        <label class="fs-2 col-6 brownColor bold" for="permissions">{{ trans('dashboard.roles.permissions') }}</label>
                                        <div class="col-6 d-flex justify-content-end">
                                            <button class="blueBk text-white btnMainStyle">اختيار الكل</button>
                                        </div>
                                    </div>
                                    <div class="row  p-3" style="background-color: #f7f7f7 ;border-radius: 10px;
                                                               box-shadow: 1px 1px 20px #f7f7f7;margin: 20px auto;" >
                                        @foreach($permissions as $permissionGroup)
                                            <div class="col-md-6">
                                                <div style="border: 1px solid lightgrey;
                                                            border-style: dotted;
                                                            background: #fff;
                                                            margin: 20px;
                                                            border-radius: 10px;
                                                            padding: 20px 0;">
                                                    <h3 class="mb-4 text-center pb-3 bold brownColor"
                                                        style="border-bottom: 1px solid lightgrey;
                                                                border-bottom-style: dotted;">{{ $permissionGroup['name'] }}</h3>
                                                    <div class="row mt-2 mb-5 ps-4 pe-4">
                                                        @foreach($permissionGroup['controls'] as $control)
                                                            <div class="form-group col-md-6 mb-3">
                                                                <input type="checkbox" name="role_permissions[]" value="{{ $control['id'] }}" {{ $role->hasPermissionTo($control['id']) ? 'checked' : '' }}>
                                                                <label class="fs-5 mainColor" style="margin-right: 8px">{{ $control['name'] }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                    @endforeach
                                </div>

                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary mt-5">{{ trans('dashboard.save') }}</button>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var triggerTabList = [].slice.call(document.querySelectorAll('#languageTabs a'))
            triggerTabList.forEach(function (triggerEl) {
                var tabTrigger = new bootstrap.Tab(triggerEl)
                triggerEl.addEventListener('click', function (event) {
                    event.preventDefault()
                    tabTrigger.show()
                })
            })
        });
    </script>
@endsection
