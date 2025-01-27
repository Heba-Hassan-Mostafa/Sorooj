@extends('admin.layouts.master')
@section('title')
    {{ trans('dashboard.sidebar.blogs') }}
@endsection
@section('content')
    <h4 class="py-3">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/
            </span>
        </a>
        {{ trans('dashboard.sidebar.blogs') }}
    </h4>
    <a href="{{ route('admin.blogs.blogs.create') }}" class=" mainBtnStyle me-2 mb-2">
        {{ trans('dashboard.blogs.add-blog') }}
    </a>
    <a href="{{ route('admin.blogs.sort-blogs') }}" class="btn btn-warning font-weight-bold p-2"
       role="button" aria-pressed="true"> <i style="font-size: 16px" class="fas fa-sort"></i>
        {{ trans('dashboard.change_order') }}</a>
    <div class="card mt-3">
        <div class="table-responsive p-2">
            <table class="myDatatable table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('dashboard.blogs.blog_image') }}</th>
                    <th>{{ trans('dashboard.blogs.blog_name') }}</th>
                    <th>{{ trans('dashboard.blogs.blog_category') }}</th>
                    <th>{{ trans('dashboard.blogs.author_name') }}</th>
                    <th>{{ trans('dashboard.blogs.publish_date') }}</th>
                    <th>{{ trans('dashboard.blogs.view_count') }}</th>
                    <th>{{ trans('dashboard.blogs.download_count') }}</th>
                    <th>{{ trans('dashboard.status') }}</th>
                    <th>{{ trans('dashboard.options') }}</th>

                </tr>
                </thead>
                <tbody>
                @foreach ($blogs as $blog)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if (!empty($blog->image))
                                <img src="{{ asset($blog->image) }}" style="width:75px;height:75px;"  alt=""/>
                            @else
                                <img src="{{ asset('assets/admin/images/blogs.webp') }}" style="width:75px;height:75px;"  alt=""/>
                            @endif

                        </td>
                        <td>{{ $blog->blog_name }}</td>
                        <td>{{ $blog->category?->name }}</td>
                        <td>{{ $blog->author_name }}</td>
                        <td>{{ $blog->publish_date }}</td>
                        <td>{{ $blog->view_count ?? 0 }}</td>
                        <td>{{ $blog->download_count ?? 0 }}</td>

                        <td>
                            <label class="switch switch-success" for="{{ $blog->id }}">
                                <input type="checkbox" class="switch-input status" id="{{ $blog->id }}"
                                       data-id="{{ $blog->id }}" {{ $blog->status == true ? 'checked' : '' }} />
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
                                    <a href="{{ route('admin.blogs.blogs.edit',$blog->id) }}"  class="btn btn-info btn-sm text-white"  title="{{ trans('dashboard.edit') }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a onclick="fireDeleteEvent({{ $blog->id }})" type="button"
                                       title="{{ trans('dashboard.delete') }}" data-toggle="tooltip"
                                       class="btn btn-danger btn-sm text-white"><i class="fas fa-trash-alt"></i></a>

                                    <form action="{{ route('admin.blogs.blogs.destroy', $blog->id) }}" method="POST"
                                          id="form-{{ $blog->id }}">
                                        @csrf
                                        @method('Delete')
                                    </form>
                                <a href="{{ route('admin.blogs.videos.sort',$blog->id) }}"  class="btn btn-warning btn-sm text-white"  title="{{ trans('dashboard.blogs.blog-videos-reorder') }}">
                                    <i class="fas fa-sort"></i>
                                </a>
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

                    url: '{{ route('admin.blogs.blogs.change-status') }}',

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
