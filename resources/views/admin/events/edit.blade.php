@extends('admin.layouts.master')
@section('css')
@endsection
@section('title')
    {{ trans('dashboard.events.edit-event') }}
@endsection
@section('content')
    <h4 class="py-3 mb-4 mainColorStyle cairo">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/ </span>
        </a>
        <a href="{{ route('admin.events.upcoming-events.index') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.sidebar.upcoming-events') }}/</span>
        </a>
        {{ trans('dashboard.events.edit-event') }}
    </h4>
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.events.upcoming-events.update',$event->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row titleInput">
                        <div class="col-6 mb-3">
                            <label for="main_title" class="form-label">{{ trans('dashboard.events.main-title') }}</label>
                            <input type="text" name="main_title" value="{{ old('main_title',$event->main_title) }}" class="form-control" />
                            @error('main_title')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 mb-3">
                            <label for="event_title" class="form-label">{{ trans('dashboard.events.event-title') }}</label>
                            <input type="text" name="event_title" value="{{ old('event_title',$event->event_title) }}" class="form-control" />
                            @error('event_title')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 mb-3">
                            <label for="instructor" class="form-label">{{ trans('dashboard.events.instructor') }}</label>
                            <input type="text" name="instructor" value="{{ old('instructor',$event->instructor) }}" class="form-control" />
                            @error('instructor')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 mb-3">
                            <label for="event_date" class="form-label">{{ trans('dashboard.events.event-date') }}</label>
                            <input type="date" name="event_date_date" value="{{ old('event_date_date',$event->event_date?->format('Y-m-d')) }}" class="form-control" />
                            @error('event_date_date')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="event_date" class="form-label">{{ trans('dashboard.events.event-time') }}</label>
                            <input type="time" name="event_date_time" value="{{ old('event_date_time',$event->event_date?->format('H:i')) }}" class="form-control" />
                            @error('event_date_time')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 mb-3">
                            <label for="country_time" class="form-label">{{ trans('dashboard.events.country-time') }}</label>
                            <input type="text" name="country_time" value="{{ old('country_time',$event->country_time) }}" class="form-control" />
                            @error('country_time')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 mb-3">
                            <label for="location" class="form-label">{{ trans('dashboard.events.location') }}</label>
                            <input type="text" name="location" value="{{ old('location',$event->location) }}" class="form-control" />
                            @error('location')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 mb-3 mt-1">
                            <label for="image" class="form-label">{{ trans('dashboard.image') }}</label>
                            <input type="file" name="image" value="{{ old('image') }}" class="form-control" />
                            @if($event->getFirstMediaUrl('image'))
                                <img src="{{ $event->getFirstMediaUrl('image') }}" alt="Course Image" class="img-thumbnail mt-2" width="200" height="200">
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
