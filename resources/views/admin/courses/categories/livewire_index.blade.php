@extends('admin.layouts.master')
@section('title')
    {{ trans('dashboard.sidebar.courses-categories') }}
@endsection
@section('content')
    <h4 class="py-3">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/
            </span>
        </a>
        {{ trans('dashboard.sidebar.courses-categories') }}
    </h4>
    <div class="card">
        @livewire('category-course-reorder')
    </div>


@endsection
