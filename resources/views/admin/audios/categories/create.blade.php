@extends('admin.layouts.master')
@section('css')
@endsection
@section('title')
    {{ trans('dashboard.audios.add-audio-category') }}
@endsection
@section('content')
    <h4 class="py-3 mb-4">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/ </span>
        </a>
        <a href="{{ route('admin.audios.category.index') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.sidebar.audios-categories') }}/</span>
        </a>
        {{ trans('dashboard.audios.add-audio-category') }}
    </h4>
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.audios.category.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="first_name" class="form-label">{{ trans('dashboard.audios.audio-category-name') }}</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" />
                            @error('name')
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
@section('scripts')

@endsection
