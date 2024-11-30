@extends('admin.layouts.master')
@section('title')
    {{ trans('dashboard.courses.course-videos-reorder') }}
@endsection
@section('content')
    <h4 class="py-3">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/
            </span>
        </a>
        <a href="{{ route('admin.courses.courses.index') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.sidebar.courses') }}/</span>
        </a>
        {{ trans('dashboard.courses.course-videos-reorder') }}
    </h4>
    <div class="card">

        @livewire('videos-reorder',['course' => $course])

    </div>

@endsection
