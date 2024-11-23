@extends('admin.layouts.master')
@section('css')
    <link href="{{ asset('assets/admin/vendor/libs/treeview/treeview-rtl.css') }}">
@endsection
@section('title')
    {{ trans('dashboard.courses.add-course-category') }}
@endsection
@section('content')
    <h4 class="py-3 mb-4">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/ </span>
        </a>
        <a href="{{ route('admin.courses.category.index') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.sidebar.courses-categories') }}/</span>
        </a>
        {{ trans('dashboard.courses.add-course-category') }}
    </h4>
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.courses.category.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="first_name" class="form-label">{{ trans('dashboard.courses.course-category-name') }}</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" />
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="col-lg-12">
                            <ul id="treeview1">
                                <h4 class="selectCatTo"> {{ trans('dashboard.courses.choose-category') }}</h4>
                                <li><a href="#">{{ trans('dashboard.sidebar.courses-categories') }}</a>
                                    <ul class="row fristParent">
                                </li>
                                @foreach ($categories as $category)
                                    <ul class="col-4 parentCategory">
                                        <label style="font-size: 16px;">
                                            <input type="radio" name="parent_id" value="{{ $category->id }}" class="name">
                                            {{ $category->name }}
                                        </label>

                                        @include('admin.courses.categories.subCategoryList', [
                                            'subcategories' => $category->subcategory,
                                        ])
                                    </ul>
                                @endforeach

                            </ul>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">{{ trans('dashboard.save') }} </button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('assets/admin/vendor/libs/treeview/treeview.js') }}"></script>

@endsection
