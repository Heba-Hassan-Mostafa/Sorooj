@extends('admin.layouts.master')
@section('title')
    {{ trans('dashboard.sidebar.settings-about') }}
@endsection
@section('content')
    <h4 class="py-3 mb-4">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/ </span>
        </a>
        <a href="{{ route('admin.settings.aboutCenter') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.sidebar.settings-about') }}</span>
        </a>
    </h4>
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="about_center" class="form-label">{{ trans('dashboard.settings.about_center') }}</label>
                            <textarea  name="about-center[content]" class="form-control" cols="10" rows="3">{{ $settings['about-center']['content'] ?? '' }}</textarea>
                            @error('about_center')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="about_video" class="form-label">{{ trans('dashboard.settings.about_center_video') }}</label>
                            <input type="text" name="about-center[video]" value="{{ $settings['about-center']['video'] ?? '' }}" class="form-control" />
                            @error('about_video')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="vision" class="form-label">{{ trans('dashboard.settings.vision') }}</label>
                            <textarea name="vision[content]" class="form-control" cols="10" rows="3">{{ $settings['vision']['content'] ?? '' }}</textarea>
                            @error('vision')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="message" class="form-label">{{ trans('dashboard.settings.message') }}</label>
                            <textarea name="message[content]" class="form-control" cols="10" rows="3">{!! $settings['message']['content'] ?? '' !!} </textarea>
                            @error('message')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                            <div class="col-12 mb-3">
                                <label for="general-objectives" class="form-label">{{ trans('dashboard.settings.general-objectives') }}</label>
                                <textarea name="general-objectives" class="form-control"  cols="30" rows="10"  id='ckeditor'>{{ $settings['general-objectives'] ?? '' }}</textarea>
                                @error('general-objectives')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        @php
                            $tracksCenterAreas = $settings['tracks-center-areas'] ?? [];
                            $tracks = isset($tracksCenterAreas['tracks'])
                                ? (is_string($tracksCenterAreas['tracks'])
                                    ? json_decode($tracksCenterAreas['tracks'], true)
                                    : $tracksCenterAreas['tracks'])
                                : [];
                        @endphp

                        <div class="col-12 mb-3">
                            <label for="tracks-content" class="form-label">Content</label>
                            <textarea class="form-control" id="tracks-content" name="tracks-center-areas[content]" rows="3">{{ $tracksCenterAreas['content'] ?? '' }}</textarea>
                        </div>

                        @if(is_array($tracks))
                            @foreach ($tracks as $index => $track)
                                <div class="col-6 mb-3">
                                    <label for="track-title-{{ $index }}" class="form-label">{{ trans('dashboard.settings.track-title') }} {{ $index + 1 }}</label>
                                    <input type="text" class="form-control" id="track-title-{{ $index }}" name="tracks-center-areas[tracks][{{ $index }}][title]" value="{{ $track['title'] ?? '' }}">
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="track-content-{{ $index }}" class="form-label">{{ trans('dashboard.settings.track-content') }} {{ $index + 1 }}</label>
                                    <textarea class="form-control" id="track-content-{{ $index }}" name="tracks-center-areas[tracks][{{ $index }}][content]" rows="3">{{ $track['content'] ?? '' }}</textarea>
                                </div>
                            @endforeach
                        @endif

                        <!-- Center Mechanism -->
                        @php
                            $points = is_string($settings['center-mechanism']['points'])
                                ? json_decode($settings['center-mechanism']['points'], true)
                                : $settings['center-mechanism']['points'];
                        @endphp

                        @if (is_array($points))
                            @foreach ($points as $index => $point)
                                <div class="col-6 mb-3">
                                    <label for="title-{{ $index }}" class="form-label">{{ trans('dashboard.settings.point') }} {{ $index + 1 }}</label>
                                    <input type="text" class="form-control" id="point-{{ $index }}" name="center-mechanism[points][{{ $index }}][title]" value="{{ $point['title'] }}">
                                </div>
                            @endforeach
                        @endif

                    </div>

                        <button type="submit" class="btn btn-primary">{{ trans('dashboard.save') }} </button>
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
