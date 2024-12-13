@extends('admin.layouts.master')
@section('css')
@endsection
@section('title')
    {{ trans('dashboard.slider.edit-slider') }}
@endsection
@section('content')
    <h4 class="py-3 mb-4  mainColorStyle cairo">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/ </span>
        </a>
        <a href="{{ route('admin.slider.slider.index') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.sidebar.slider') }}/</span>
        </a>
        {{ trans('dashboard.slider.edit-slider') }}
    </h4>
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.slider.slider.update', $slider->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row titleInput">
                            <div class="col-6 mb-3">
                                <label for="title" class="form-label">{{ trans('dashboard.slider.title') }}</label>
                                <input type="text" name="title" value="{{ old('title' , $slider->title) }}" class="form-control" />
                                @error('title')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-6 mb-3">
                                <label for="link" class="form-label">{{ trans('dashboard.slider.link') }}</label>
                                <input type="text" name="link" value="{{ old('link', $slider->link) }}" class="form-control" />
                                @error('link')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        <div class="col-6 mb-3">
                            <label for="image" class="form-label titles">{{ trans('dashboard.image') }}</label>
                            <input type="file" name="image" class="form-control" />

                            @if($slider->getFirstMediaUrl('image'))
                                <img src="{{ $slider->getFirstMediaUrl('image') }}" alt="Course Image" class="img-thumbnail mt-2" width="150" height="135">
                            @endif

                            @error('image')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        </div>

                    <button type="submit" class="titles outline-none">{{ trans('dashboard.save') }} </button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')

@endsection

