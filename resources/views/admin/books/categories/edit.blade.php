@extends('admin.layouts.master')
@section('css')
    <link href="{{ asset('assets/admin/vendor/libs/treeview/treeview-rtl.css') }}">
@endsection
@section('title')
    {{ trans('dashboard.books.edit-book-category') }}
@endsection
@section('content')
    <h4 class="py-3 mb-4">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/ </span>
        </a>
        <a href="{{ route('admin.books.category.index') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.sidebar.books-categories') }}/</span>
        </a>
        {{ trans('dashboard.books.edit-book-category') }}
    </h4>
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.books.category.update', $category->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="first_name" class="form-label">{{ trans('dashboard.books.book-category-name') }}</label>
                            <input type="text" name="name" value="{{ $category->name }}" class="form-control" />
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="col-lg-12">
                            <ul id="treeview1">
                                <h4 class="selectCatTo"> {{ trans('dashboard.books.choose-category') }}</h4>
                                <li><a href="#">{{ trans('dashboard.sidebar.books-categories') }}</a>
                                    <ul class="row fristParent">
                                </li>
                                @foreach ($parentCategories  as $parentCategory)
                                    <ul class="col-4 parentCategory">
                                        <label style="font-size: 16px;">
                                            <input type="radio" name="parent_id" value= "{{ $parentCategory->id }}"
                                                {{ old('parent_id',$category->parent_id) == $parentCategory->id ?'checked' : '' }}>
                                            {{ $parentCategory->name }}
                                        </label>

                                        @include('admin.books.categories.subCategoryListEdit', [
                                            'subcategories' => $parentCategory->subcategory,
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
