@extends('admin.layouts.master')
@section('title')
    {{ trans('dashboard.sidebar.books') }}
@endsection
@section('content')
    <h4 class="py-3">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/
            </span>
        </a>
        {{ trans('dashboard.sidebar.books') }}
    </h4>
    <a href="{{ route('admin.books.books.create') }}" class=" mainBtnStyle me-2 mb-2">
        {{ trans('dashboard.books.add-book') }}
    </a>
    <a href="{{ route('admin.books.sort-books') }}" class="btn btn-warning font-weight-bold p-2"
       role="button" aria-pressed="true"> <i style="font-size: 16px" class="fas fa-sort"></i>
        {{ trans('dashboard.change_order') }}</a>
    <div class="card mt-4">
        <div class="table-responsive p-2">
            <table class="myDatatable table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('dashboard.books.book_image') }}</th>
                    <th>{{ trans('dashboard.books.book_name') }}</th>
                    <th>{{ trans('dashboard.books.book_category') }}</th>
                    <th>{{ trans('dashboard.books.author_name') }}</th>
                    <th>{{ trans('dashboard.books.publish_date') }}</th>
                    <th>{{ trans('dashboard.books.view_count') }}</th>
                    <th>{{ trans('dashboard.books.download_count') }}</th>
                    <th>{{ trans('dashboard.status') }}</th>
                    <th>{{ trans('dashboard.options') }}</th>

                </tr>
                </thead>
                <tbody>
                @foreach ($books as $book)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if (!empty($book->image))
                                <img src="{{ asset($book->image) }}" style="width:75px;height:75px;"  alt=""/>
                            @else
                                <img src="{{ asset('assets/admin/images/books.webp') }}" style="width:75px;height:75px;"  alt=""/>
                            @endif

                        </td>
                        <td>{{ $book->book_name }}</td>
                        <td>{{ $book->category?->name }}</td>
                        <td>{{ $book->author_name }}</td>
                        <td>{{ $book->publish_date }}</td>
                        <td>{{ $book->view_count ?? 0 }}</td>
                        <td>{{ $book->download_count ?? 0 }}</td>
                        <td>
                            <label class="switch switch-success" for="{{ $book->id }}">
                                <input type="checkbox" class="switch-input status" id="{{ $book->id }}"
                                       data-id="{{ $book->id }}" {{ $book->status == true ? 'checked' : '' }} />
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
                            <div class="m-2 d-flex">
                                    <a href="{{ route('admin.books.books.edit',$book->id) }}"  class="btn btn-info btn-sm text-white me-2"  title="{{ trans('dashboard.edit') }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a onclick="fireDeleteEvent({{ $book->id }})" type="button"
                                       title="{{ trans('dashboard.delete') }}" data-toggle="tooltip"
                                       class="btn btn-danger btn-sm text-white"><i class="fas fa-trash-alt"></i></a>

                                    <form action="{{ route('admin.books.books.destroy', $book->id) }}" method="POST"
                                          id="form-{{ $book->id }}">
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

@endsection
@section('scripts')

    <script>
        $(function() {

            $('#DataTables_Table_0').on('change','.status',  function() {

                var status = $(this).prop('checked') === true ? 1 : 0;

                var id = $(this).data('id');
                console.log(status);

                $.ajax({

                    type: "GET",

                    dataType: "json",

                    url: '{{ route('admin.books.books.change-status') }}',

                    data: {
                        'status': status,
                        'id': id
                    },

                    success: function(data) {

                        console.log(data.success)

                    }

                });

            })

        })
    </script>
@endsection
