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
    {{ trans('dashboard.courses.edit-course') }}
@endsection
@section('content')
    <h4 class="py-3 mb-4  mainColorStyle cairo">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/ </span>
        </a>
        <a href="{{ route('admin.courses.courses.index') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.sidebar.courses') }}/</span>
        </a>
        {{ trans('dashboard.courses.edit-course') }}
    </h4>
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.courses.courses.update', $course->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row titleInput">
                        <div class="col-6 mb-3">
                            <label for="course_name" class="form-label">{{ trans('dashboard.courses.course_name') }}</label>
                            <input type="text" name="course_name" value="{{ old('course_name', $course->course_name) }}" class="form-control" />
                            @error('course_name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 mb-3">
                            <label for="author_name" class="form-label">{{ trans('dashboard.courses.author_name') }}</label>
                            <input type="text" name="author_name" value="{{ old('author_name', $course->author_name) }}" class="form-control" />
                            @error('author_name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 mb-3">
                            <label for="brief_description" class="form-label">{{ trans('dashboard.courses.brief_description') }}</label>
                            <input type="text" name="brief_description" value="{{ old('brief_description', $course->brief_description) }}" class="form-control" />
                            @error('brief_description')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="publish_date" class="form-label">{{ trans('dashboard.courses.publish_date') }}</label>
                            <input type="text" name="publish_date" value="{{ old('publish_date', $course->publish_date) }}" class="form-control" id="publish_date" />
                            @error('publish_date')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="col-lg-12">
                            <ul id="treeview1" class="list-unstyled">
                                <h4 class="selectCatTo">
                                    <i class="fa-solid fa-list"></i>
                                    {{ trans('dashboard.courses.choose-category') }}</h4>
                                <li class="allCateSelect grayBgColorStyle"><a href="#">{{ trans('dashboard.sidebar.courses-categories') }}</a>
                                    <ul class="row fristParent">
                                </li>
                                @foreach ($categories as $category)
                                    <ul class="col-4 parentCategory">
                                        <label style="font-size: 16px;">
                                            <input type="radio" name="category_id" value="{{ $category->id }}"
                                                   {{ $course->category_id == $category->id ? 'checked' : '' }}
                                                   class="name">
                                            {{ $category->name }}
                                        </label>

                                        @include('admin.courses.courses.subCategoryListEdit', [
                                            'subcategories' => $category->subcategory,
                                            'selectedCategoryId' => $course->category_id,
                                        ])
                                    </ul>
                                @endforeach
                                @error('category_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </ul>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="course_name" class="form-label titles">
                                <i class="fa-solid fa-pen-to-square"></i>
                                {{ trans('dashboard.courses.course_content') }}</label>
                            <textarea name="course_content" class="form-control" cols="30" rows="10" id='ckeditor'>
                                {!! old('course_content', $course->course_content) !!}</textarea>
                            @error('course_content')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


{{--                            <div id="videoInputs">--}}
{{--                                @foreach ($course->videos as $index => $video)--}}
{{--                                    <div class="row mb-2 videosBox">--}}
{{--                                        <input type="hidden" name="videos[{{ $index }}][id]" value="{{ $video->id }}">--}}
{{--                                        <div class="col-5">--}}
{{--                                            <input type="text" name="videos[{{ $index }}][name]" class="form-control"--}}
{{--                                                   value="{{ $video->name }}"--}}
{{--                                                   placeholder="{{ trans('dashboard.courses.video_name') }}">--}}
{{--                                        </div>--}}
{{--                                        <div class="col-5">--}}
{{--                                            <input type="text" name="videos[{{ $index }}][youtube_link]" class="form-control"--}}
{{--                                                   value="{{ $video->youtube_link }}"--}}
{{--                                                   placeholder="{{ trans('dashboard.courses.enter_youtube_link') }}">--}}
{{--                                        </div>--}}
{{--                                        <div class="col-2">--}}
{{--                                            <button type="button" class="btn btn-danger removeVideo">{{ trans('dashboard.remove') }}</button>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                @endforeach--}}
{{--                            </div>--}}
{{--                            <button type="button" class="btn btn-success addVideo">{{ trans('dashboard.add') }}</button>--}}
{{--                        </div>--}}

                            <!-- Videos Repeater -->
                        <div id="videos-repeater"  class="mb-4">
                            <label for="videos" class="form-label titles">
                                {{ trans('dashboard.courses.videos_youtube_links') }}
                            </label>
                                <!-- Existing Videos -->
                                @foreach($course->videos as $index => $video)
                                <div class="video-row mb-3">
                                    <div class="row mb-2">
                                            <div class="col-5">
                                                <input type="hidden" name="videos[{{ $video->id }}][id]" value="{{ $video->id }}">
                                                <input type="text" name="videos[{{ $video->id }}][name]" class="form-control" value="{{ $video->name }}" placeholder="{{ trans('dashboard.courses.video_name') }}">
                                            </div>
                                            <div class="col-5">
                                                <input type="text" name="videos[{{ $video->id }}][youtube_link]" class="form-control" value="{{ $video->youtube_link }}" placeholder="{{ trans('dashboard.courses.enter_youtube_link') }}">
                                            </div>
                                            <div class="col-2">
                                                <button type="button" class="btn btn-danger remove-video-row" {{ $loop->first ? 'disabled' : '' }}>{{trans('dashboard.remove')}}</button>
                                                <button type="button" id="add-video-row" class="btn btn-success addVideo">{{trans('dashboard.add')}}</button>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="col-6 mb-3">
                            <label for="attachments" class="form-label titles">
                                <i class="fa-solid fa-file-pdf"></i>
                                {{ trans('dashboard.attachments') }}
                            </label>
                            <input type="file" name="attachments[]" class="form-control" accept=".pdf" multiple />
                            <div class="" id="attachmentList">
                                @foreach($course->getMedia('attachments') as $attachment)
                                    <div class="attachment-item grayBgColorStyle pdfFiles" data-id="{{ $attachment->id }}">
                                        <i class="far fa-file-pdf" style="color: red"></i>
                                        <a href="{{ $attachment->getUrl() }}" class="cairo mainColorStyle bold" target="_blank">{{ $attachment->file_name }}</a>

                                        <!-- Delete Button -->
                                        <button type="button" class="btn btn-danger btn-sm delete-attachment" data-id="{{ $attachment->id }}">
                                            {{ trans('dashboard.delete') }}
                                        </button>
                                        <br>
                                    </div>
                                @endforeach
                            </div>
                            @error('attachments')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="image" class="form-label titles">{{ trans('dashboard.image') }}</label>
                            <input type="file" name="image" class="form-control" />

                            @if($course->getFirstMediaUrl('image'))
                                <img src="{{ $course->getFirstMediaUrl('image') }}" alt="Course Image" class="img-thumbnail mt-2" width="150" height="135">
                                <button type="button" class="btn btn-danger btn-sm delete-image" data-id="{{ $course->id }}">
                                    {{ trans('dashboard.delete') }} {{ trans('dashboard.image') }}
                                </button>
                            @endif

                            @error('image')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 mb-3 mt-1">
                            <label for="exam_link" class="form-label titles">{{ trans('dashboard.courses.exam_link') }}</label>
                            <input type="text" name="exam_link" value="{{ old('exam_link', $course->exam_link) }}" class="form-control" />
                            @error('exam_link')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label for="keywords" class="form-label">{{ trans('dashboard.keywords') }}</label>
                            <input type="text" name="keywords" value="{{ old('keywords', $course->keywords) }}" class="form-control" />
                            @error('keywords')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label for="description" class="form-label">{{ trans('dashboard.description') }}</label>
                            <textarea name="description" class="form-control" cols="30" rows="10">{{ old('description', $course->description) }}</textarea>
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
            let videoIndex = {{ $course->videos->count() }}; // Start index for new videos

            // Add new video row
            document.getElementById('add-video-row').addEventListener('click', () => {
                const videosRepeater = document.getElementById('videos-repeater');
                const newVideoRow = document.createElement('div');
                newVideoRow.classList.add('video-row', 'mb-3');

                newVideoRow.innerHTML = `
                <div class="row">
                    <div class="col-5">
                        <input type="text" name="videos[new][${videoIndex}][name]" class="form-control" placeholder="{{ trans('dashboard.courses.video_name') }}">
                    </div>
                    <div class="col-5">
                        <input type="text" name="videos[new][${videoIndex}][youtube_link]" class="form-control" placeholder="{{ trans('dashboard.courses.enter_youtube_link') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger remove-video-row">{{trans('dashboard.remove')}}</button>
                    </div>
                </div>
            `;

                videosRepeater.appendChild(newVideoRow);
                videoIndex++;
            });

            // Remove video row
            document.getElementById('videos-repeater').addEventListener('click', (e) => {
                if (e.target && e.target.classList.contains('remove-video-row')) {
                    const videoRow = e.target.closest('.video-row');

                    // Ensure the first row of existing videos cannot be removed
                    const allRows = document.querySelectorAll('.video-row');
                    if (allRows[0] === videoRow && !videoRow.querySelector('input[name^="videos[new]"]')) {
                        return; // Do nothing if trying to remove the first row of existing videos
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

    <script>
        $(document).on('click', '.delete-attachment', function() {
            var attachmentId = $(this).data('id');
            var attachmentItem = $(this).closest('.attachment-item');

           // if (confirm('Are you sure you want to delete this attachment?')) {
                $.ajax({
                    url: '{{ url("admin/courses/courses/" . $course->id . "/attachments") }}/' + attachmentId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}' // CSRF token for security
                    },
                    success: function(response) {
                        // Remove the attachment item from the UI
                        attachmentItem.remove();
                      //  alert('Attachment deleted successfully.');
                    },
                    error: function(xhr) {
                        alert('Error deleting attachment: ' + xhr.responseText);
                    }
                });
           // }
        });
    </script>

    <script>
        // AJAX for deleting the course image
        $(document).on('click', '.delete-image', function() {
            var courseId = $(this).data('id');
            var imageButton = $(this);

            //if (confirm('Are you sure you want to delete this image?')) {
                $.ajax({
                    url: '{{ url("admin/courses/courses") }}/' + courseId + '/image', // Define the route URL
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Remove the image and button from the UI
                        imageButton.prev('img').remove(); // Remove the image
                        imageButton.remove(); // Remove the delete button
                       // alert('Image deleted successfully.');
                    },
                    error: function(xhr) {
                        alert('Error deleting image: ' + xhr.responseText);
                    }
                });
            //}
        });
    </script>
@endsection

