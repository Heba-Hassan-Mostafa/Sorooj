@extends('admin.layouts.master')
@section('title')
    {{ trans('dashboard.sidebar.management-members') }}
@endsection
@section('content')
    <h4 class="py-3">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/
            </span>
        </a>
        {{ trans('dashboard.sidebar.management-members') }}
    </h4>
    <a href="{{ route('admin.management-members.create') }}" class="btn btn-primary mb-2">
        {{ trans('dashboard.members.add-new-member') }}
    </a>
    <a href="{{ route('admin.management-members.sort-members') }}" class="btn btn-warning font-weight-bold p-2"
       role="button" aria-pressed="true"> <i style="font-size: 16px" class="fas fa-sort"></i>
        {{ trans('dashboard.change_order') }}</a>
    <div class="card">
        <div class="table-responsive p-2">
            <table class="myDatatable table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('dashboard.image') }}</th>
                    <th>{{ trans('dashboard.members.name') }}</th>
                    <th>{{ trans('dashboard.members.position') }}</th>
                    <th>{{ trans('dashboard.status') }}</th>
                    <th>{{ trans('dashboard.options') }}</th>

                </tr>
                </thead>
                <tbody>
                @foreach ($members as $member)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if (!empty($member->avatar))
                                <img src="{{ asset($member->avatar) }}" style="width:50px;height:50px;" />
                            @else
                                <img src="{{ asset('assets/avatar.jpg') }}" style="width:50px;height:50px;" />
                            @endif

                        </td>
                        <td>{{ $member->name }}</td>
                        <td>{{ $member->position }}</td>
                        <td>
                            <label class="switch switch-success" for="{{ $member->id }}">
                                <input type="checkbox" class="switch-input status" id="{{ $member->id }}"
                                       data-id="{{ $member->id }}" {{ $member->is_active == true ? 'checked' : '' }} />
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

                                <a href="{{ route('admin.management-members.edit',$member->id) }}"  class="btn btn-info btn-sm text-white"  title="{{ trans('dashboard.edit') }}">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a onclick="fireDeleteEvent({{ $member->id }})" type="button"
                                   title="{{ trans('dashboard.delete') }}" data-toggle="tooltip"
                                   class="btn btn-danger btn-sm text-white"><i class="fas fa-trash-alt"></i></a>

                                <form action="{{ route('admin.management-members.destroy', $member->id) }}" method="POST"
                                      id="form-{{ $member->id }}">
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

                    url: '{{ route('admin.management-members.change-status') }}',

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
