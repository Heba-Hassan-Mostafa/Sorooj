@extends('admin.layouts.master')
@section('title')
    {{ trans('dashboard.sidebar.clients') }}
@endsection
@section('content')
    <h4 class="py-3">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/
            </span>
        </a>
        {{ trans('dashboard.sidebar.clients') }}
    </h4>
    <div class="card">
        <div class="table-responsive p-2">
            <table class="myDatatable table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('dashboard.admins.name') }}</th>
                    <th>{{ trans('dashboard.admins.email') }}</th>
                    <th>{{ trans('dashboard.admins.mobile') }}</th>
                    <th>{{ trans('dashboard.admins.status') }}</th>
                    <th>{{ trans('dashboard.options') }}</th>

                </tr>
                </thead>
                <tbody>
                @foreach ($clients as $client)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $client->fullName() }}</td>
                        <td>{{ $client->email }}</td>
                        <td>{{ $client->mobile }}</td>

                        <td>
                            <label class="switch switch-success" for="{{ $client->id }}">
                                <input type="checkbox" class="switch-input status" id="{{ $client->id }}"
                                       data-id="{{ $client->id }}" {{ $client->is_active == true ? 'checked' : '' }} />
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
                                    <a onclick="fireDeleteEvent({{ $client->id }})" type="button"
                                       title="{{ trans('dashboard.delete') }}" data-toggle="tooltip"
                                       class="btn btn-danger btn-sm text-white"><i class="fas fa-trash-alt"></i></a>

                                    <form action="{{ route('admin.clients.destroy', $client->id) }}" method="POST"
                                          id="form-{{ $client->id }}">
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

                    url: '{{ route('admin.clients.change-status') }}',

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
