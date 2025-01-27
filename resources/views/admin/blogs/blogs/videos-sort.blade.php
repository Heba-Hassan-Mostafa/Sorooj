@extends('admin.layouts.master')
@section('title')
    {{ trans('dashboard.blogs.blog-videos-reorder') }}
@endsection
@section('content')
    <h4 class="py-3">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/
            </span>
        </a>
        <a href="{{ route('admin.blogs.blogs.index') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.sidebar.blogs') }}/</span>
        </a>
        {{ trans('dashboard.blogs.blog-videos-reorder') }}
    </h4>
    <div class="card">

        @livewire('blog-videos-reorder',['blog' => $blog])

    </div>

@endsection
