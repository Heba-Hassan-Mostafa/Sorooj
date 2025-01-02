@extends('admin.layouts.master')
@section('title')
    {{ trans('dashboard.sidebar.settings-about') }}
@endsection
@section('content')
    <h4 class="py-3 mb-4">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/ </span>
        </a>
        <a href="{{ route('admin.settings.index') }}">
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
                            <input type="text" name="about-center[content]" value="{{ $settings['about-center']['content'] ?? '' }}" class="form-control" />
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
                            <input type="text" name="vision[content]" value="{{ $settings['vision']['content'] ?? '' }}" class="form-control" />
                            @error('vision')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="message" class="form-label">{{ trans('dashboard.settings.message') }}</label>
                            <input type="text" name="message[content]" value="{{ $settings['message']['content'] ?? '' }}" class="form-control" />
                            @error('message')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <h4>{{ trans('dashboard.settings.general-objectives') }}</h4>
                    @foreach ($settings['general-objectives'] as $index => $objective)
                            <div class="col-6 mb-3">
                                <label for="general-objectives-{{ $index }}" class="form-label">{{ trans('dashboard.settings.general-objectives') }} {{ $index + 1 }}</label>
                                <input type="text" class="form-control" id="general-objectives-{{ $index }}" name="general-objectives[]" value="{{ $objective }}">
                                @error('general-objectives')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        @endforeach

                        <!-- Tracks Center Areas -->
                        <h4>Tracks Center Areas</h4>
                        <div class="col-6 mb-3">
                            <label for="tracks-content" class="form-label">Content</label>
                            <textarea class="form-control" id="tracks-content" name="tracks-center-areas[content]" rows="3">{{ $settings['tracks-center-areas']['content'] }}</textarea>
                        </div>
                        @foreach (json_decode($settings['tracks-center-areas']['tracks'], true) as $index => $track)
                            <div class="col-6 mb-3">
                                <label for="track-title-{{ $index }}" class="form-label">Track Title {{ $index + 1 }}</label>
                                <input type="text" class="form-control" id="track-title-{{ $index }}" name="tracks-center-areas[tracks][{{ $index }}][title]" value="{{ $track['title'] }}">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="track-content-{{ $index }}" class="form-label">Track Content {{ $index + 1 }}</label>
                                <textarea class="form-control" id="track-content-{{ $index }}" name="tracks-center-areas[tracks][{{ $index }}][content]" rows="3">{{ $track['content'] }}</textarea>
                            </div>
                        @endforeach


{{--                        <!-- Center Mechanism -->--}}
{{--                        <h3>Center Mechanism</h3>--}}
{{--                        @if (isset($settings['center-mechanism']['points']) && is_array($settings['center-mechanism']['points']))--}}
{{--                            @foreach ($settings['center-mechanism']['points'] as $index => $point)--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label for="center-mechanism-{{ $index }}" class="form-label">Mechanism {{ $index + 1 }}</label>--}}
{{--                                    <textarea class="form-control" id="center-mechanism-{{ $index }}" name="center-mechanism[points][{{ $index }}][title]" rows="3">--}}
{{--                    {{ $point['title'] }}--}}
{{--                </textarea>--}}
{{--                                </div>--}}
{{--                            @endforeach--}}
{{--                        @else--}}
{{--                            <p>No mechanisms found. Please add some mechanisms in the settings.</p>--}}
{{--                        @endif--}}


                    </div>

                    <button type="submit" class="btn btn-primary">{{ trans('dashboard.save') }} </button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(function() {

            //select2 with search
            function matchStart(params, data) {
                // If there are no search terms, return all of the data
                if ($.trim(params.term) === '') {
                    return data;
                }

                // Skip if there is no 'children' property
                if (typeof data.children === 'undefined') {
                    return null;
                }

                // `data.children` contains the actual options that we are matching against
                var filteredChildren = [];
                $.each(data.children, function(idx, child) {
                    if (child.text.toUpperCase().indexOf(params.term.toUpperCase()) == 0) {
                        filteredChildren.push(child);
                    }
                });

                // If we matched any of the timezone group's children, then set the matched children on the group
                // and return the group object
                if (filteredChildren.length) {
                    var modifiedData = $.extend({}, data, true);
                    modifiedData.children = filteredChildren;

                    // You can return modified objects from here
                    // This includes matching the `children` how you want in nested data sets
                    return modifiedData;
                }

                // Return `null` if the term should not be displayed
                return null;
            }

            $(".select2").select2({
                tags: true,
                closeOnSelect: false,
                minimumResultsForSearch: Infinity,
                matcher: matchStart
            });
        });
    </script>
@endsection
