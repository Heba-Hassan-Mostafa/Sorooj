@extends('admin.layouts.master')
@section('title')
    {{ trans('dashboard.sidebar.courses') }}
@endsection
@section('content')
    <h4 class="py-3">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/
            </span>
        </a>
        {{ trans('dashboard.sidebar.courses') }}
    </h4>
    <a href="{{ route('admin.courses.courses.create') }}" class="btn btn-primary mb-2">
        {{ trans('dashboard.courses.add-course') }}
    </a>
    <a href="{{ route('admin.courses.sort-courses') }}" class="btn btn-warning font-weight-bold p-2"
       role="button" aria-pressed="true"> <i style="font-size: 16px" class="fas fa-sort"></i>
        {{ trans('dashboard.change_order') }}</a>
    <div class="card">
        <div class="table-responsive p-2">
            <table class="myDatatable table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('dashboard.courses.course_image') }}</th>
                    <th>{{ trans('dashboard.courses.course_name') }}</th>
                    <th>{{ trans('dashboard.courses.course_category') }}</th>
                    <th>{{ trans('dashboard.courses.author_name') }}</th>
                    <th>{{ trans('dashboard.courses.publish_date') }}</th>
                    <th>{{ trans('dashboard.courses.view_count') }}</th>
                    <th>{{ trans('dashboard.status') }}</th>
                    <th>{{ trans('dashboard.options') }}</th>

                </tr>
                </thead>
                <tbody>
                @foreach ($courses as $course)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if (!empty($course->image))
                                <img src="{{ asset($course->image) }}" style="width:50px;height:50px;"  alt=""/>
                            @else
                                <img src="{{ asset('assets/admin/images/course.jpg') }}" style="width:50px;height:50px;"  alt=""/>
                            @endif

                        </td>
                        <td>{{ $course->course_name }}</td>
                        <td>{{ $course->category?->name }}</td>
                        <td>{{ $course->author_name }}</td>
                        <td>{{ $course->publish_date }}</td>
                        <td>{{ $course->view_count ?? 0 }}</td>

                        <td>
                            <label class="switch switch-success" for="{{ $course->id }}">
                                <input type="checkbox" class="switch-input status" id="{{ $course->id }}"
                                       data-id="{{ $course->id }}" {{ $course->status == true ? 'checked' : '' }} />
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
                                    <a href="{{ route('admin.courses.courses.edit',$course->id) }}"  class="btn btn-info btn-sm text-white"  title="{{ trans('dashboard.edit') }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a onclick="fireDeleteEvent({{ $course->id }})" type="button"
                                       title="{{ trans('dashboard.delete') }}" data-toggle="tooltip"
                                       class="btn btn-danger btn-sm text-white"><i class="fas fa-trash-alt"></i></a>

                                    <form action="{{ route('admin.courses.courses.destroy', $course->id) }}" method="POST"
                                          id="form-{{ $course->id }}">
                                        @csrf
                                        @method('Delete')
                                    </form>

                                <a href="{{ route('admin.courses.videos.sort',$course->id) }}"  class="btn btn-warning btn-sm text-white"  title="{{ trans('dashboard.courses.course-videos-reorder') }}">
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

                    url: '{{ route('admin.courses.courses.change-status') }}',

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
