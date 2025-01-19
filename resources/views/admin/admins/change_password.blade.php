@extends('admin.layouts.master')
@section('title')
    {{ trans('dashboard.change-password') }}
@endsection
@section('content')
    <h4 class="py-3 mb-4">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/ </span>
        </a>

        {{ trans('dashboard.change-password') }}
    </h4>
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.change-password') }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">

                        <div class="col-6 mb-3">
                            <label for="old_password" class="form-label">{{ trans('dashboard.old-password') }}</label>
                            <input type="password" name="old_password" value="" class="form-control" />
                            @error('old_password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="new_password" class="form-label">{{ trans('dashboard.new-password') }}</label>
                            <input type="password" name="password" value="" class="form-control" />
                            @error('password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="new_password_confirmation"
                                   class="form-label">{{ trans('dashboard.new-password-confirmation') }}</label>
                            <input type="password" name="password_confirmation" value="" class="form-control" />
                            @error('password_confirmation')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary">{{ trans('dashboard.save') }} </button>
                </form>
            </div>
        </div>
    </div>
@endsection
