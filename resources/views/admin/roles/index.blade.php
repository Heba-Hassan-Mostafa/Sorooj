@extends('admin.layouts.master')
@section('title')
    {{ trans('dashboard.sidebar.roles') }}
@endsection
@section('content')
    <h4 class="py-3">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/
            </span>
        </a>
        {{ trans('dashboard.sidebar.roles') }}
    </h4>
    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary mb-2">
        {{ trans('dashboard.roles.add-new-role') }}
    </a>
    <div class="card">
        <div class="table-responsive p-2">
            <table class="myDatatable table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('dashboard.roles.role-name') }}</th>
                    <th>{{ trans('dashboard.roles.status') }}</th>
                    <th>{{ trans('dashboard.options') }}</th>

                </tr>
                </thead>
                <tbody>
                @foreach ($roles as $role)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            <label class="switch switch-success" for="{{ $role->id }}">
                                <input type="checkbox" class="switch-input status" id="{{ $role->id }}"
                                       data-id="{{ $role->id }}" {{ $role->status == true ? 'checked' : '' }} />
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
{{--                                @if ($role->getTranslation('name', 'en') !== 'admin' && $role->getTranslation('name', 'ar') !== 'أدمن')--}}
                                <a href="{{ route('admin.roles.edit',$role->id) }}"  class="btn btn-info btn-sm text-white"  title="{{ trans('dashboard.edit') }}">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <a onclick="fireDeleteEvent({{ $role->id }})" type="button"
                                   title="{{ trans('dashboard.delete') }}" data-toggle="tooltip"
                                   class="btn btn-danger btn-sm text-white"><i class="fas fa-trash-alt"></i></a>

                                <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST"
                                      id="form-{{ $role->id }}">
                                    @csrf
                                    @method('Delete')
                                </form>
{{--                                @else--}}
{{--                                    <i class="fas fa-lock text-secondary" title="{{ trans('dashboard.locked') }}"></i>--}}

{{--                                @endif--}}
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

                    url: '{{ route('admin.roles.change-status') }}',

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
