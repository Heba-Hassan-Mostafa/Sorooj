@extends('admin.layouts.master')
@section('title')
    {{ trans('dashboard.sidebar.live') }}
@endsection
@section('content')
    <h4 class="py-3 mb-4">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/ </span>
        </a>
        <a href="{{ route('admin.settings.live') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.sidebar.live') }}</span>
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
                            <label for="youtube-live" class="form-label">{{ trans('dashboard.settings.youtube-live') }}</label>
                            <input type="text" name="youtube-live" value="{{ $settings['youtube-live'] ?? '' }}" class="form-control" />
                            @error('youtube-live')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="telegram-live" class="form-label">{{ trans('dashboard.settings.telegram-live') }}</label>
                            <input type="text" name="telegram-live" value="{{ $settings['telegram-live'] ?? '' }}" class="form-control" />
                            @error('telegram-live')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="facebook-live" class="form-label">{{ trans('dashboard.settings.facebook-live') }}</label>
                            <input type="text" name="facebook-live" value="{{ $settings['facebook-live'] ?? '' }}" class="form-control" />
                            @error('facebook-live')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="mixlr-live" class="form-label">{{ trans('dashboard.settings.mixlr-live') }}</label>
                            <input type="text" name="mixlr-live" value="{{ $settings['mixlr-live'] ?? '' }}" class="form-control" />
                            @error('mixlr-live')
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
