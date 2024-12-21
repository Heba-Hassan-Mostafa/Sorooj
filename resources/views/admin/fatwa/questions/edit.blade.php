@extends('admin.layouts.master')
@section('css')
@endsection
@section('title')
    {{ trans('dashboard.fatwa.answer') }}
@endsection
@section('content')
    <h4 class="py-3 mb-4  mainColorStyle cairo">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/ </span>
        </a>
        <a href="{{ route('admin.fatwa.questions.index') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.sidebar.questions') }}/</span>
        </a>
        {{ trans('dashboard.fatwa.answer') }}
    </h4>
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.fatwa.questions.update', $question->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row titleInput">
                            <div class="col-6 mb-3">
                                <label for="message" class="form-label">{{ trans('dashboard.fatwa.question') }}</label>
                                <textarea name="message" class="form-control" readonly>{!! $question->message !!}</textarea>
                            </div>
                        <div class="col-12 mb-3">
                            <label for="answer_content" class="form-label">{{ trans('dashboard.fatwa.answer') }}</label>
                            <textarea name="answer_content" cols="30" rows="10" class="form-control" id="ckeditor"></textarea>
                            @error('answer_content')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 mb-3">
                            <label for="publish_date" class="form-label">{{ trans('dashboard.blogs.publish_date') }}</label>
                            <input type="date" name="publish_date" value="{{ old('publish_date') }}" class="form-control"/>
                            @error('publish_date')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 mb-3">
                            <label for="audio_file" class="form-label">{{ trans('dashboard.fatwa.audio_file') }}</label>
                            <input type="file" name="audio_file" value="{{ old('audio_file') }}" class="form-control"/>
                            @error('audio_file')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="col-6 mb-3">
                            <label for="youtube_link" class="form-label">{{ trans('dashboard.fatwa.youtube_link') }}</label>
                            <input type="text" name="youtube_link" value="{{ old('youtube_link') }}" class="form-control" />
                            @error('youtube_link')
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
@endsection

