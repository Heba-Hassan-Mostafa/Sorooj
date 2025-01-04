@extends('admin.layouts.master')
@section('title')
    {{ trans('dashboard.sidebar.audios-categories') }}
@endsection
@section('content')
    <h4 class="py-3">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/
            </span>
        </a>
        {{ trans('dashboard.sidebar.audios-categories') }}
    </h4>
    <div class="card">
        @livewire('category-audio-reorder')
    </div>


@endsection
