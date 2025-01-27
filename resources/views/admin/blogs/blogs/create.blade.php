@extends('admin.layouts.master')
@section('css')
    <link href="{{ asset('assets/admin/vendor/libs/treeview/treeview-rtl.css') }}">
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
    {{ trans('dashboard.blogs.add-blog') }}
@endsection
@section('content')
    <h4 class="py-3 mb-4 mainColorStyle cairo">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/ </span>
        </a>
        <a href="{{ route('admin.blogs.blogs.index') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.sidebar.blogs') }}/</span>
        </a>
        {{ trans('dashboard.blogs.add-blog') }}
    </h4>
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.blogs.blogs.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row titleInput">
                        <div class="col-6 mb-3">
                            <label for="blog_name" class="form-label">{{ trans('dashboard.blogs.blog_name') }}</label>
                            <input type="text" name="blog_name" value="{{ old('blog_name') }}" class="form-control" />
                            @error('blog_name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 mb-3">
                            <label for="author_name" class="form-label">{{ trans('dashboard.blogs.author_name') }}</label>
                            <input type="text" name="author_name" value="{{ old('author_name') }}" class="form-control" />
                            @error('author_name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 mb-3">
                            <label for="blog_name" class="form-label">{{ trans('dashboard.blogs.brief_description') }}</label>
                            <input type="text" name="brief_description" value="{{ old('brief_description') }}" class="form-control" />
                            @error('brief_description')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="publish_date" class="form-label">{{ trans('dashboard.blogs.publish_date') }}</label>
                            <input type="text" name="publish_date" value="{{ old('publish_date') }}" class="form-control" id="publish_date" />
                            @error('publish_date')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-lg-12">
                            <ul id="treeview1" class="list-unstyled">
                                <div>
                                    <h4 class="selectCatTo">
                                        <i class="fa-solid fa-list"></i>
                                        {{ trans('dashboard.blogs.choose-category') }}</h4>

                                </div>
                                <li class="allCateSelect grayBgColorStyle"><a href="#">{{ trans('dashboard.sidebar.blogs-categories') }}</a>
                                    <ul class="row fristParent">
                                </li>
                                @foreach ($categories as $category)
                                    <ul class="col-3 parentCategory">
                                        <label style="font-size: 16px;">
                                            <input type="radio" name="category_id" value="{{ $category->id }}" class="name">
                                            {{ $category->name }}
                                        </label>

                                        @include('admin.blogs.blogs.subCategoryList', [
                                            'subcategories' => $category->subcategory,
                                        ])
                                    </ul>
                                @endforeach
                                @error('category_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </ul>
                        </div>

                        <div class="col-12 mb-3">

                            <label for="blog_name" class="form-label titles">
                                <i class="fa-solid fa-pen-to-square"></i>
                                {{ trans('dashboard.blogs.blog_content') }}</label>
                            <textarea name="blog_content" class="form-control" cols="30" rows="10"  id='ckeditor'>
                                {!! old('blog_content') !!}</textarea>
                            @error('blog_content')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Videos Repeater -->
                        <div id="videos-repeater"  class="mb-4">
                            <label for="videos" class="form-label titles">
                                {{ trans('dashboard.blogs.videos_youtube_links') }}
                            </label>
                            <div class="video-row mb-3">
                                <div class="row mb-2">
                                    <div class="col-5">
                                        <input type="text" name="videos[0][name]" class="form-control" placeholder="{{ trans('dashboard.blogs.video_name') }}">
                                    </div>
                                    <div class="col-5">
                                        <input type="text" name="videos[0][youtube_link]" class="form-control" placeholder="{{ trans('dashboard.blogs.enter_youtube_link') }}" >
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-danger remove-video-row" disabled>{{trans('dashboard.remove')}}</button>
                                        <button type="button" id="add-video-row" class="btn btn-success addVideo">{{ trans('dashboard.add') }}</button>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 mb-3 mt-1">
                            <label for="attachments" class="form-label titles">
                                <i class="fa-solid fa-file-pdf"></i>
                                {{ trans('dashboard.attachments') }}</label>
                            <input type="file" name="attachments[]" class="form-control" accept=".pdf" multiple />
                            @error('attachments')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 mb-3 mt-1">
                            <label for="image" class="form-label titles">{{ trans('dashboard.image') }}</label>
                            <input type="file" name="image" value="{{ old('image') }}" class="form-control" />
                            @error('image')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="audio_file" class="form-label">{{ trans('dashboard.audios.audio_file') }}</label>
                            <input type="file" name="audio_file" class="form-control" />
                            @error('audio_file')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label for="keywords" class="form-label">{{ trans('dashboard.keywords') }}</label>
                            <input type="text" name="keywords" value="{{ old('keywords') }}" class="form-control" />
                            @error('keywords')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label for="description" class="form-label">{{ trans('dashboard.description') }}</label>
                            <textarea name="description" class="form-control" cols="30" rows="10">{!! old('description') !!}</textarea>
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
    <script src="{{ asset('assets/admin/vendor/libs/treeview/treeview.js') }}"></script>

    {{--    Add new input for video--}}


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let videoIndex = 1; // Keeps track of video rows

            // Add new video row
            document.getElementById('add-video-row').addEventListener('click', () => {
                const videosRepeater = document.getElementById('videos-repeater');
                const newVideoRow = document.createElement('div');
                newVideoRow.classList.add('video-row', 'mb-3');

                newVideoRow.innerHTML = `
                <div class="row">
                    <div class="col-5">
                        <input type="text" name="videos[${videoIndex}][name]" class="form-control" placeholder="{{ trans('dashboard.blogs.video_name') }}" required>
                    </div>
                    <div class="col-5">
                        <input type="text" name="videos[${videoIndex}][youtube_link]" class="form-control" placeholder="{{ trans('dashboard.blogs.enter_youtube_link') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger remove-video-row">{{trans('dashboard.remove')}}</button>
                    </div
                </div>
            `;

                videosRepeater.appendChild(newVideoRow);
                videoIndex++;
            });

            // Remove video row
            document.getElementById('videos-repeater').addEventListener('click', (e) => {
                if (e.target && e.target.classList.contains('remove-video-row')) {
                    const videoRow = e.target.closest('.video-row');

                    // Ensure the first row cannot be removed
                    const allRows = document.querySelectorAll('.video-row');
                    if (allRows[0] === videoRow) {
                        return; // Do nothing if trying to remove the first row
                    }

                    videoRow.remove();
                }
            });
        });
    </script>


{{--    ckeditor    --}}
    <script src="{{ asset('assets/admin/vendor/libs/texteditor/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.config.language = 'ar';
        CKEDITOR.replace('ckeditor', {
            filebrowserImageBrowseUrl: '/file-manager/ckeditor',
            contentsCss: [
                'https://fonts.googleapis.com/css2?family=Cairo&family=Amiri&family=Almarai&family=Aref+Ruqaa&family=El+Messiri&family=Reem+Kufi&display=swap',
                'path/to/your/custom/styles.css' // If you have any custom styles
            ],
            font_names: 'Traditional Arabic/Traditional Arabic;' +
                'Cairo/Cairo;Amiri/Amiri;Almarai/Almarai;El Messiri/El Messiri;Reem Kufi/Reem Kufi;Aref Ruqaa/Aref Ruqaa;' +
                CKEDITOR.config.font_names
        });
    </script>

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
