@extends('admin.layouts.master')
@section('title')
    {{ trans('dashboard.sidebar.books-categories') }}
@endsection
@section('content')
    <h4 class="py-3">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/
            </span>
        </a>
        {{ trans('dashboard.sidebar.books-categories') }}
    </h4>
    <a href="{{ route('admin.books.category.create') }}" class="mainBtnStyle mb-2">
        {{ trans('dashboard.books.add-book-category') }}
    </a>
    <a href="{{ route('admin.books.category.sort-categories') }}" class="btn btn-warning font-weight-bold p-2"
       role="button" aria-pressed="true"> <i style="font-size: 16px" class="fas fa-sort"></i>
        {{ trans('dashboard.change_order') }}</a>
    <div class="card mt-4">

        <div class="table-responsive p-2">

            <div class="col-md mb-4 mb-md-2">
                <div class="accordion mt-3" id="accordionWithIcon">
                    <div class="card accordion-item active">
                        <h2 class="accordion-header d-flex align-items-center">
                            <button
                                type="button"
                                class="accordion-button"
                                data-bs-toggle="collapse"
                                data-bs-target="#accordionWithIcon-1"
                                aria-expanded="true">
                                <i class="ti ti-star ti-xs me-2"></i>
                                {{trans('dashboard.books.parent-categories')}}
                            </button>
                        </h2>

                        <div id="accordionWithIcon-1" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                <table class="myDatatable table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ trans('dashboard.books.book-category-name') }}</th>
                                        <th>{{ trans('dashboard.books.book-count') }}</th>
                                        <th>{{ trans('dashboard.created_at') }}</th>
                                        <th>{{ trans('dashboard.status') }}</th>
                                        <th>{{ trans('dashboard.options') }}</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category?->books?->count() ?? 0 }}</td>
                                            <td>{{ $category->created_at->format('Y-m-d') }}</td>

                                            <td>
                                                <label class="switch switch-success" for="{{ $category->id }}">
                                                    <input type="checkbox" class="switch-input status" id="{{ $category->id }}"
                                                           data-id="{{ $category->id }}" {{ $category->status == true ? 'checked' : '' }} />
                                                    <span class="switch-toggle-slider">
                                        <span class="switch-on">
                                            <i class="ti ti-check"></i>
                                        </span>
                                        <span class="switch-off">
                                            <i class="ti ti-x"></i>
                                        </span>
                                    </span>
                                                </label>
                                            </td>
                                            <td>
                                                <div class="m-2">
                                                    <a href="{{ route('admin.books.category.edit',$category->id) }}"  class="btn btn-info btn-sm text-white"  title="{{ trans('dashboard.edit') }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>

                                                    <a onclick="fireDeleteEvent({{ $category->id }})" type="button"
                                                       title="{{ trans('dashboard.delete') }}" data-toggle="tooltip"
                                                       class="btn btn-danger btn-sm text-white"><i class="fas fa-trash-alt"></i></a>

                                                    <form action="{{ route('admin.books.category.destroy', $category->id) }}" method="POST"
                                                          id="form-{{ $category->id }}">
                                                        @csrf
                                                        @method('Delete')
                                                    </form>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item card">
                        <h2 class="accordion-header d-flex align-items-center">
                            <button
                                type="button"
                                class="accordion-button collapsed"
                                data-bs-toggle="collapse"
                                data-bs-target="#accordionWithIcon-2"
                                aria-expanded="false">
                                <i class="me-2 ti ti-sun ti-xs"></i>
                                {{trans('dashboard.books.book-subcategories')}}
                            </button>
                        </h2>
                        <div id="accordionWithIcon-2" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <table class="myDatatable table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ trans('dashboard.books.book-category-name') }}</th>
                                        <th>{{ trans('dashboard.books.book-count') }}</th>
                                        <th>{{ trans('dashboard.created_at') }}</th>
                                        <th>{{ trans('dashboard.books.parent-category') }}</th>
                                        <th>{{ trans('dashboard.status') }}</th>
                                        <th>{{ trans('dashboard.options') }}</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($subCategories as $subCategory)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $subCategory->name }}</td>
                                            <td>{{ $subCategory?->books?->count() ?? 0 }}</td>
                                            <td>{{ $subCategory->created_at->format('Y-m-d') }}</td>
                                            <td>{{ $subCategory->parent != '' ? $subCategory->parent->name : '---' }}</td>
                                            <td>
                                                <label class="switch switch-success" for="{{ $subCategory->id }}">
                                                    <input type="checkbox" class="switch-input status" id="{{ $subCategory->id }}"
                                                           data-id="{{ $subCategory->id }}" {{ $subCategory->status == true ? 'checked' : '' }} />
                                                    <span class="switch-toggle-slider">
                                        <span class="switch-on">
                                            <i class="ti ti-check"></i>
                                        </span>
                                        <span class="switch-off">
                                            <i class="ti ti-x"></i>
                                        </span>
                                    </span>
                                                </label>
                                            </td>
                                            <td>
                                                <div class="m-2">
                                                    <a href="{{ route('admin.books.category.edit',$subCategory->id) }}"  class="btn btn-info btn-sm text-white"  title="{{ trans('dashboard.edit') }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>

                                                    <a onclick="fireDeleteEvent({{ $subCategory->id }})" type="button"
                                                       title="{{ trans('dashboard.delete') }}" data-toggle="tooltip"
                                                       class="btn btn-danger btn-sm text-white"><i class="fas fa-trash-alt"></i></a>

                                                    <form action="{{ route('admin.books.category.destroy', $subCategory->id) }}" method="POST"
                                                          id="form-{{ $subCategory->id }}">
                                                        @csrf
                                                        @method('Delete')
                                                    </form>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                </div>
            </div>


        </div>
    </div>

@endsection
@section('scripts')

    <script>
        $(function() {
            // Remove any previously bound event listeners to prevent duplication
            $('.myDatatable').off('change', '.status').on('change', '.status', function() {
                var status = $(this).prop('checked') === true ? 1 : 0;
                var id = $(this).data('id');
                console.log('Status:', status, 'ID:', id);

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('admin.books.category.change-status') }}',
                    data: {
                        'status': status,
                        'id': id
                    },
                    success: function(data) {
                        console.log(`Category: ${id} Status changed successfully.`);
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText);
                    }
                });
            });
        });
    </script>

@endsection
