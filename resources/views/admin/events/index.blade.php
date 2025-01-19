@extends('admin.layouts.master')
@section('title')
    {{ trans('dashboard.sidebar.upcoming-events') }}
@endsection
@section('content')
    <h4 class="py-3">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/
            </span>
        </a>
        {{ trans('dashboard.sidebar.upcoming-events') }}
    </h4>
    <a href="{{ route('admin.events.upcoming-events.create') }}" class=" mainBtnStyle me-2  mb-2">
        {{ trans('dashboard.events.add-event') }}
    </a>
    <div class="card mt-3">
        <div class="table-responsive p-2">
            <table class="myDatatable table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('dashboard.events.image') }}</th>
                    <th>{{ trans('dashboard.events.main-title') }}</th>
                    <th>{{ trans('dashboard.events.event-title') }}</th>
                    <th>{{ trans('dashboard.events.instructor') }}</th>
                    <th>{{ trans('dashboard.events.day') }}</th>
                    <th>{{ trans('dashboard.events.event-date') }}</th>
                    <th>{{ trans('dashboard.events.event-time') }}</th>
                    <th>{{ trans('dashboard.events.country-time') }}</th>
                    <th>{{ trans('dashboard.events.location') }}</th>
                    <th>{{ trans('dashboard.status') }}</th>
                    <th>{{ trans('dashboard.options') }}</th>

                </tr>
                </thead>
                <tbody>
                @foreach ($events as $event)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if (!empty($event->image))
                                <img src="{{ asset($event->image) }}" style="width:50px;height:50px;"  alt=""/>
                            @else
                                <img src="{{ asset('assets/admin/images/events.webp') }}" style="width:50px;height:50px;"  alt=""/>
                            @endif

                        </td>
                        <td>{{ $event->main_title ?? '-----' }}</td>
                        <td>{{ $event->event_title ?? '-----' }}</td>
                        <td>{{ $event->instructor ?? '-----' }}</td>
                        <td>{{ $event->event_date?->translatedFormat('l') }}</td>
                        <td>{{ $event->event_date?->format('Y-m-d') }}</td>
                        <td>{{ $event->event_date?->format('H:i a') }}</td>
                        <td>{{ $event->country_time }}</td>
                        <td>{{ $event->location }}</td>
                        <td>
                            <label class="switch switch-success" for="{{ $event->id }}">
                                <input type="checkbox" class="switch-input status" id="{{ $event->id }}"
                                       data-id="{{ $event->id }}" {{ $event->status == true ? 'checked' : '' }} />
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
                                    <a href="{{ route('admin.events.upcoming-events.edit',$event->id) }}"  class="btn btn-info btn-sm text-white"  title="{{ trans('dashboard.edit') }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a onclick="fireDeleteEvent({{ $event->id }})" type="button"
                                       title="{{ trans('dashboard.delete') }}" data-toggle="tooltip"
                                       class="btn btn-danger btn-sm text-white"><i class="fas fa-trash-alt"></i></a>

                                    <form action="{{ route('admin.events.upcoming-events.destroy', $event->id) }}" method="POST"
                                          id="form-{{ $event->id }}">
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

                    url: '{{ route('admin.events.upcoming-events.change-status') }}',

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
