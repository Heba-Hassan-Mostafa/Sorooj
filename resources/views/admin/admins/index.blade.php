@extends('admin.layouts.master')
@section('title')
    {{ trans('dashboard.sidebar.admins') }}
@endsection
@section('content')
    <h4 class="py-3">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/
            </span>
        </a>
        {{ trans('dashboard.sidebar.admins') }}
    </h4>
    <a href="{{ route('admin.admins.create') }}" class="btn btn-primary mb-2">
        {{ trans('dashboard.admins.add-new-admin') }}
    </a>
    <div class="card">
        <div class="table-responsive p-2">
            <table class="myDatatable table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('dashboard.image') }}</th>
                    <th>{{ trans('dashboard.admins.name') }}</th>
                    <th>{{ trans('dashboard.admins.email') }}</th>
                    <th>{{ trans('dashboard.admins.mobile') }}</th>
                    <th>{{ trans('dashboard.admins.admin-role') }}</th>
                    <th>{{ trans('dashboard.admins.status') }}</th>
                    <th>{{ trans('dashboard.options') }}</th>

                </tr>
                </thead>
                <tbody>
                @foreach ($admins as $admin)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if (!empty($admin->avatar))
                                <img src="{{ asset($admin->avatar) }}" style="width:50px;height:50px;" />
                            @else
                                <img src="{{ asset('assets/avatar.jpg') }}" style="width:50px;height:50px;" />
                            @endif

                        </td>
                        <td>{{ $admin->fullName() }}</td>
                        <td>{{ $admin->email }}</td>
                        <td>{{ $admin->mobile }}</td>
                        <td>
                            @if (!empty($admin->getRoleNames()))
                                @foreach ($admin->getRoleNames() as $role)
                                    @php
                                        $roleName = json_decode($role, true);
                                        $localizedRoleName = $roleName[app()->getLocale()] ?? $roleName['en'] ?? $role;
                                    @endphp
                                    <label class="btn btn-success" style="pointer-events: none">{{ $localizedRoleName }}</label>
                                @endforeach
                            @endif
                        </td>

                        <td>
                            <label class="switch switch-success" for="{{ $admin->id }}">
                                <input type="checkbox" class="switch-input status" id="{{ $admin->id }}"
                                       data-id="{{ $admin->id }}" {{ $admin->is_active == true ? 'checked' : '' }} />
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
                                @php
                                    // Decode the JSON role
                                    $hasAdminRole = $admin->getRoleNames()->contains(function ($role) {
                                        $roleArray = json_decode($role, true);
                                        return isset($roleArray['en']) && $roleArray['en'] === 'admin';
                                    });
                                @endphp

                                @if (!$hasAdminRole)
                                <a href="{{ route('admin.admins.edit',$admin->id) }}"  class="btn btn-info btn-sm text-white"  title="{{ trans('dashboard.edit') }}">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a onclick="fireDeleteEvent({{ $admin->id }})" type="button"
                                   title="{{ trans('dashboard.delete') }}" data-toggle="tooltip"
                                   class="btn btn-danger btn-sm text-white"><i class="fas fa-trash-alt"></i></a>

                                <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST"
                                      id="form-{{ $admin->id }}">
                                    @csrf
                                    @method('Delete')
                                </form>
                                @else
                                    <i class="fas fa-lock text-secondary" title="{{ trans('dashboard.locked') }}"></i>
                                @endif
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

                    url: '{{ route('admin.admins.change-status') }}',

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
