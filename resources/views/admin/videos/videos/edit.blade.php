@extends('admin.layouts.master')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/pickadate/themes/classic.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/pickadate/themes/classic.date.css') }}">
    <style>
        .picker__select--month,
        .picker__select--year {
            padding: 0 !important;
        }
    </style>
@endsection
@section('title')
    {{ trans('dashboard.videos.edit-video') }}
@endsection
@section('content')
    <h4 class="py-3 mb-4  mainColorStyle cairo">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/ </span>
        </a>
        <a href="{{ route('admin.videos.videos.index') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.sidebar.videos') }}/</span>
        </a>
        {{ trans('dashboard.videos.edit-video') }}
    </h4>
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.videos.videos.update', $video->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row titleInput">
                        <div class="col-6 mb-3">
                            <label for="name" class="form-label">{{ trans('dashboard.videos.video_name') }}</label>
                            <input type="text" name="name" value="{{ old('video_name', $video->name) }}" class="form-control" />
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="youtube_link" class="form-label">{{ trans('dashboard.fatwa.youtube_link') }}</label>
                            <input type="text" name="youtube_link" value="{{ old('youtube_link' ,$video->youtube_link) }}" class="form-control" />
                            @error('youtube_link')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="category_id" class="form-label">{{ trans('dashboard.videos.category_id') }}</label>
                            <select name="category_id" class="form-select">
                                <option value="">{{ trans('dashboard.videos.select-category') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ $video->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 mb-3">
                            <label for="brief_description" class="form-label">{{ trans('dashboard.videos.brief_description') }}</label>
                            <input type="text" name="brief_description" value="{{ old('brief_description', $video->brief_description) }}" class="form-control" />
                            @error('brief_description')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="publish_date" class="form-label">{{ trans('dashboard.videos.publish_date') }}</label>
                            <input type="text" name="publish_date" value="{{ old('publish_date', $video->publish_date) }}" class="form-control" id="publish_date" />
                            @error('publish_date')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label for="keywords" class="form-label">{{ trans('dashboard.keywords') }}</label>
                            <input type="text" name="keywords" value="{{ old('keywords', $video->keywords) }}" class="form-control" />
                            @error('keywords')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label for="description" class="form-label">{{ trans('dashboard.description') }}</label>
                            <textarea name="description" class="form-control" cols="30" rows="10">{{ old('description', $video->description) }}</textarea>
                            @error('description')
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
    {{--    pickadate    --}}
    <script src="{{ asset('assets/admin/vendor/libs/pickadate/picker.js') }}"></script>
    <script src="{{ asset('assets/admin/vendor/libs/pickadate/picker.date.js') }}"></script>
    <script>
        $('#publish_date').pickadate({
            format: 'yyyy-mm-dd',
            selectMonths: true, // Creates a dropdown to control month
            selectYears: false, // Creates a dropdown to control month
            clear: 'Clear',
            close: 'Ok',
            closeOnSelect: true // Close upon selecting a date,
        });
        var publishdate = $('#publish_date').pickadate('picker');


        $('#publish_date').change(function() {
            selected_ci_date = "";
            selected_ci_date = $('#publish_date').val();
            if (selected_ci_date != null) {
                var cidate = new Date(selected_ci_date);
                min_codate = "";
                min_codate = new Date();
                min_codate.setDate(cidate.getDate() + 1);

            }
        });
    </script>


@endsection

