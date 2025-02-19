@extends('admin.layouts.master')
@section('css')
    <link href="{{ asset('assets/admin/vendor/libs/treeview/treeview-rtl.css') }}">
@endsection
@section('title')
    {{ trans('dashboard.courses.edit-course-category') }}
@endsection
@section('content')
    <h4 class="py-3 mb-4">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/ </span>
        </a>
        <a href="{{ route('admin.courses.category.index') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.sidebar.courses-categories') }}/</span>
        </a>
        {{ trans('dashboard.courses.edit-course-category') }}
    </h4>
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.courses.category.update', $category->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="first_name" class="form-label">{{ trans('dashboard.courses.course-category-name') }}</label>
                            <input type="text" name="name" value="{{ $category->name }}" class="form-control" />
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="col-lg-12">
                            <ul id="treeview1" class="list-unstyled">
                                <h4 class="selectCatTo"> {{ trans('dashboard.courses.choose-category') }}</h4>
                                <li class="allCateSelect grayBgColorStyle branch">
                                    <a href="#">{{ trans('dashboard.sidebar.courses-categories') }}</a>
                                    <ul class="row fristParent">
                                </li>
                                @foreach ($parentCategories  as $parentCategory)
                                    <ul class="col-4 parentCategory">
                                        <label style="font-size: 16px;">
                                            <input type="radio" name="parent_id" value= "{{ $parentCategory->id }}"
                                                {{ old('parent_id',$category->parent_id) == $parentCategory->id ?'checked' : '' }}>
                                            {{ $parentCategory->name }}
                                        </label>

                                        @include('admin.courses.categories.subCategoryListEdit', [
                                            'subcategories' => $parentCategory->subcategory,
                                        ])
                                    </ul>
                                @endforeach

                            </ul>
                        </div>
                    </div>

                    <button type="submit" class="mainBtnStyle">{{ trans('dashboard.save') }} </button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('assets/admin/vendor/libs/treeview/treeview.js') }}"></script>

@endsection
