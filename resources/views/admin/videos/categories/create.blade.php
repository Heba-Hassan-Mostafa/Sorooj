@extends('admin.layouts.master')
@section('css')
@endsection
@section('title')
    {{ trans('dashboard.videos.add-video-category') }}
@endsection
@section('content')
    <h4 class="py-3 mb-4">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/ </span>
        </a>
        <a href="{{ route('admin.videos.category.index') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.sidebar.videos-categories') }}/</span>
        </a>
        {{ trans('dashboard.videos.add-video-category') }}
    </h4>
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.videos.category.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="first_name" class="form-label">{{ trans('dashboard.videos.video-category-name') }}</label>
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
