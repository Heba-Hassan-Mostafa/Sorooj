@extends('admin.layouts.master')
@section('title')
    {{ trans('dashboard.sidebar.slider') }}
@endsection
@section('content')
    <h4 class="py-3">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/
            </span>
        </a>
        {{ trans('dashboard.sidebar.slider') }}
    </h4>
    <a href="{{ route('admin.slider.slider.create') }}" class="btn btn-primary mb-2">
        {{ trans('dashboard.slider.add-slider') }}
    </a>
    <a href="{{ route('admin.slider.sort-slider') }}" class="btn btn-warning font-weight-bold p-2"
       role="button" aria-pressed="true"> <i style="font-size: 16px" class="fas fa-sort"></i>
        {{ trans('dashboard.change_order') }}</a>
    <div class="card">
        <div class="table-responsive p-2">
            <table class="myDatatable table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('dashboard.slider.image') }}</th>
                    <th>{{ trans('dashboard.slider.title') }}</th>
                    <th>{{ trans('dashboard.slider.link') }}</th>
                    <th>{{ trans('dashboard.slider.created_at') }}</th>
                    <th>{{ trans('dashboard.status') }}</th>
                    <th>{{ trans('dashboard.options') }}</th>

                </tr>
                </thead>
                <tbody>
                @foreach ($sliders as $slider)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if (!empty($slider->image))
                                <img src="{{ asset($slider->image) }}" style="width:50px;height:50px;"  alt=""/>
                            @else
                                <img src="{{ asset('assets/admin/images/default_slider.webp') }}" style="width:50px;height:50px;"  alt=""/>
                            @endif

                        </td>
                        <td>{{ $slider->title }}</td>
                        <td>{{ $slider->link }}</td>
                        <td>{{ $slider->created_at->format('Y-m-d') }}</td>
                        <td>
                            <label class="switch switch-success" for="{{ $slider->id }}">
                                <input type="checkbox" class="switch-input status" id="{{ $slider->id }}"
                                       data-id="{{ $slider->id }}" {{ $slider->status == true ? 'checked' : '' }} />
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
                                    <a href="{{ route('admin.slider.slider.edit',$slider->id) }}"  class="btn btn-info btn-sm text-white"  title="{{ trans('dashboard.edit') }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a onclick="fireDeleteEvent({{ $slider->id }})" type="button"
                                       title="{{ trans('dashboard.delete') }}" data-toggle="tooltip"
                                       class="btn btn-danger btn-sm text-white"><i class="fas fa-trash-alt"></i></a>

                                    <form action="{{ route('admin.slider.slider.destroy', $slider->id) }}" method="POST"
                                          id="form-{{ $slider->id }}">
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

                    url: '{{ route('admin.slider.change-status') }}',

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
