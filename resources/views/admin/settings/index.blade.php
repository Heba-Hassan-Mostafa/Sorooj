@extends('admin.layouts.master')
@section('title')
    {{ trans('dashboard.sidebar.settings-contacts') }}
@endsection
@section('content')
    <h4 class="py-3 mb-4">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/ </span>
        </a>
        <a href="{{ route('admin.settings.index') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.sidebar.settings-contacts') }}</span>
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
                            <label for="phones_man" class="form-label">{{ trans('dashboard.settings.phones_man') }}</label>
                            <input type="text" name="app-contacts[phones][man]" value="{{ $settings['app-contacts']['phones']['man'] ?? '' }}" class="form-control" />
                            @error('phones_man')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="phones_women" class="form-label">{{ trans('dashboard.settings.phones_women') }}</label>
                            <input type="text" name="app-contacts[phones][women]" value="{{ $settings['app-contacts']['phones']['women'] ?? '' }}" class="form-control" />
                            @error('phones_women')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="email" class="form-label">{{ trans('dashboard.settings.email') }}</label>
                            <input type="text" name="app-contacts[email]" value="{{ $settings['app-contacts']['email'] ?? '' }}" class="form-control" />
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="facebook" class="form-label">{{ trans('dashboard.settings.facebook') }}</label>
                            <input type="text" name="app-contacts[facebook]" value="{{ $settings['app-contacts']['facebook'] ?? '' }}" class="form-control" />
                            @error('facebook')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="instagram" class="form-label">{{ trans('dashboard.settings.instagram') }}</label>
                            <input type="text" name="app-contacts[instagram]" value="{{ $settings['app-contacts']['instagram'] ?? '' }}" class="form-control" />
                            @error('instagram')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="twitter" class="form-label">{{ trans('dashboard.settings.twitter') }}</label>
                            <input type="text" name="app-contacts[twitter]" value="{{ $settings['app-contacts']['twitter'] ?? '' }}" class="form-control" />
                            @error('twitter')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="telegram" class="form-label">{{ trans('dashboard.settings.telegram') }}</label>
                            <input type="text" name="app-contacts[telegram]" value="{{ $settings['app-contacts']['telegram'] ?? '' }}" class="form-control" />
                            @error('telegram')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="youtube" class="form-label">{{ trans('dashboard.settings.youtube') }}</label>
                            <input type="text" name="app-contacts[youtube]" value="{{ $settings['app-contacts']['youtube'] ?? '' }}" class="form-control" />
                            @error('youtube')
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
