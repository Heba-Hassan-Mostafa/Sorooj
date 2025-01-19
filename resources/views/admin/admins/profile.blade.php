@extends('admin.layouts.master')
@section('title')
    {{ trans('dashboard.profile') }}
@endsection
@section('content')
    <h4 class="py-3 mb-4">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/ </span>
        </a>
        {{ trans('dashboard.profile') }}
    </h4>
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.update-profile') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="first_name" class="form-label">{{ trans('dashboard.admins.first_name') }}</label>
                            <input type="text" name="first_name" value="{{ auth()->user()->first_name }}" class="form-control" />
                            @error('first_name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="last_name" class="form-label">{{ trans('dashboard.admins.last_name') }}</label>
                            <input type="text" name="last_name" value="{{ auth()->user()->last_name }}" class="form-control" />
                            @error('last_name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 mb-3">
                            <label for="email" class="form-label">{{ trans('dashboard.admins.email') }}</label>
                            <input type="email" name="email" value="{{ auth()->user()->email }}" class="form-control" />
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="mobile" class="form-label">{{ trans('dashboard.admins.mobile') }}</label>
                            <input type="text" name="mobile" value="{{ auth()->user()->mobile }}" class="form-control" />
                            @error('mobile')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="col-12 mb-3">
                            <label for="avatar" class="form-label">{{ trans('dashboard.image') }}</label>
                            <input type="file" name="avatar" class="form-control"/>
                            @error('avatar')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                            @if (!empty(auth()->user()->avatar))
                                <img src="{{ auth()->user()->avatar }}" style="width: 100px;height:100px;padding-top:10px">
                            @endif
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary">{{ trans('dashboard.save') }} </button>
                </form>
            </div>
        </div>
    </div>
@endsection
