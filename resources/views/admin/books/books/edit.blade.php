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
    {{ trans('dashboard.books.edit-book') }}
@endsection
@section('content')
    <h4 class="py-3 mb-4  mainColorStyle cairo">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/ </span>
        </a>
        <a href="{{ route('admin.books.books.index') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.sidebar.books') }}/</span>
        </a>
        {{ trans('dashboard.books.edit-book') }}
    </h4>
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.books.books.update', $book->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row titleInput">
                        <div class="col-6 mb-3">
                            <label for="book_name" class="form-label">{{ trans('dashboard.books.book_name') }}</label>
                            <input type="text" name="book_name" value="{{ old('book_name', $book->book_name) }}" class="form-control" />
                            @error('book_name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 mb-3">
                            <label for="author_name" class="form-label">{{ trans('dashboard.books.author_name') }}</label>
                            <input type="text" name="author_name" value="{{ old('author_name', $book->author_name) }}" class="form-control" />
                            @error('author_name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 mb-3">
                            <label for="brief_description" class="form-label">{{ trans('dashboard.books.brief_description') }}</label>
                            <input type="text" name="brief_description" value="{{ old('brief_description', $book->brief_description) }}" class="form-control" />
                            @error('brief_description')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="publish_date" class="form-label">{{ trans('dashboard.books.publish_date') }}</label>
                            <input type="text" name="publish_date" value="{{ old('publish_date', $book->publish_date) }}" class="form-control" id="publish_date" />
                            @error('publish_date')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="col-lg-12">
                            <ul id="treeview1" class="list-unstyled">
                                <h4 class="selectCatTo">
                                    <i class="fa-solid fa-list"></i>
                                    {{ trans('dashboard.books.choose-category') }}</h4>
                                <li class="allCateSelect grayBgColorStyle"><a href="#">{{ trans('dashboard.sidebar.books-categories') }}</a>
                                    <ul class="row fristParent">
                                </li>
                                @foreach ($categories as $category)
                                    <ul class="col-4 parentCategory">
                                        <label style="font-size: 16px;">
                                            <input type="radio" name="category_id" value="{{ $category->id }}"
                                                   {{ $book->category_id == $category->id ? 'checked' : '' }}
                                                   class="name">
                                            {{ $category->name }}
                                        </label>

                                        @include('admin.books.books.subCategoryListEdit', [
                                            'subcategories' => $category->subcategory,
                                            'selectedCategoryId' => $book->category_id,
                                        ])
                                    </ul>
                                @endforeach
                                @error('category_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </ul>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="book_name" class="form-label titles">
                                <i class="fa-solid fa-pen-to-square"></i>
                                {{ trans('dashboard.books.book_content') }}</label>
                            <textarea name="book_content" class="form-control" cols="30" rows="10" id='ckeditor'>
                                {!! old('book_content', $book->book_content) !!}</textarea>
                            @error('book_content')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="col-6 mb-3">
                            <label for="attachments" class="form-label titles">
                                <i class="fa-solid fa-file-pdf"></i>
                                {{ trans('dashboard.attachments') }}
                            </label>
                            <input type="file" name="attachments[]" class="form-control" accept=".pdf" multiple />
                            <div class="" id="attachmentList">
                                @foreach($book->getMedia('attachments') as $attachment)
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

                            @if($book->getFirstMediaUrl('image'))
                                <img src="{{ $book->getFirstMediaUrl('image') }}" alt="Course Image" class="img-thumbnail mt-2" width="150" height="135">
                                <button type="button" class="btn btn-danger btn-sm delete-image" data-id="{{ $book->id }}">
                                    {{ trans('dashboard.delete') }} {{ trans('dashboard.image') }}
                                </button>
                            @endif

                            @error('image')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label for="keywords" class="form-label">{{ trans('dashboard.keywords') }}</label>
                            <input type="text" name="keywords" value="{{ old('keywords', $book->keywords) }}" class="form-control" />
                            @error('keywords')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label for="description" class="form-label">{{ trans('dashboard.description') }}</label>
                            <textarea name="description" class="form-control" cols="30" rows="10">{{ old('description', $book->description) }}</textarea>
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
                    url: '{{ url("admin/books/books/" . $book->id . "/attachments") }}/' + attachmentId,
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
        // AJAX for deleting the book image
        $(document).on('click', '.delete-image', function() {
            var bookId = $(this).data('id');
            var imageButton = $(this);

            //if (confirm('Are you sure you want to delete this image?')) {
                $.ajax({
                    url: '{{ url("admin/books/books") }}/' + bookId + '/image', // Define the route URL
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

