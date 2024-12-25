@extends('admin.layouts.master')
@section('title')
    {{ trans('dashboard.sidebar.videos') }}
@endsection
@section('content')
    <h4 class="py-3">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/
            </span>
        </a>
        {{ trans('dashboard.sidebar.videos') }}
    </h4>
    <a href="{{ route('admin.videos.videos.create') }}" class="btn btn-primary mb-2">
        {{ trans('dashboard.videos.add-video') }}
    </a>
    <a href="{{ route('admin.videos.sort-videos') }}" class="btn btn-warning font-weight-bold p-2"
       role="button" aria-pressed="true"> <i style="font-size: 16px" class="fas fa-sort"></i>
        {{ trans('dashboard.change_order') }}</a>
    <div class="card">
        <div class="table-responsive p-2">
            <table class="myDatatable table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('dashboard.videos.video_name') }}</th>
                    <th>{{ trans('dashboard.videos.video_category') }}</th>
                    <th>{{ trans('dashboard.videos.publish_date') }}</th>
                    <th>{{ trans('dashboard.status') }}</th>
                    <th>{{ trans('dashboard.options') }}</th>

                </tr>
                </thead>
                <tbody>
                @foreach ($videos as $video)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $video->name }}</td>
                        <td>{{ $video->category?->name }}</td>
                        <td>{{ $video->publish_date }}</td>
                        <td>
                            <label class="switch switch-success" for="{{ $video->id }}">
                                <input type="checkbox" class="switch-input status" id="{{ $video->id }}"
                                       data-id="{{ $video->id }}" {{ $video->status == true ? 'checked' : '' }} />
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
                                    <a href="{{ route('admin.videos.videos.edit',$video->id) }}"  class="btn btn-info btn-sm text-white"  title="{{ trans('dashboard.edit') }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a onclick="fireDeleteEvent({{ $video->id }})" type="button"
                                       title="{{ trans('dashboard.delete') }}" data-toggle="tooltip"
                                       class="btn btn-danger btn-sm text-white"><i class="fas fa-trash-alt"></i></a>

                                    <form action="{{ route('admin.videos.videos.destroy', $video->id) }}" method="POST"
                                          id="form-{{ $video->id }}">
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

                    url: '{{ route('admin.videos.videos.change-status') }}',

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
