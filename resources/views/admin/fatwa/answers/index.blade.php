@extends('admin.layouts.master')
@section('title')
    {{ trans('dashboard.sidebar.answers') }}
@endsection
@section('content')
    <h4 class="py-3">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/
            </span>
        </a>
        {{ trans('dashboard.sidebar.answers') }}
    </h4>
    <div class="card">
        <div class="table-responsive p-2">
            <table class="myDatatable table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('dashboard.fatwa.user_name') }}</th>
                    <th>{{ trans('dashboard.fatwa.question') }}</th>
                    <th>{{ trans('dashboard.fatwa.created_at') }}</th>
                    <th>{{ trans('dashboard.options') }}</th>

                </tr>
                </thead>
                <tbody>
                @foreach ($answers as $answer)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td> {{ $answer->fatwaQuestion?->name }}</td>
                        <td>{{\Illuminate\Support\Str::limit( $answer->fatwaQuestion?->message , 60) }}</td>
                        <td>{{ $answer->created_at->format('Y-m-d') }}</td>
                        <td>
                            <div class="m-2">
                                <a href="{{ route('admin.fatwa.answers.edit',$answer->id) }}"
                                   class="btn btn-info btn-sm text-white"
                                   title="{{ trans('dashboard.edit') }}">
                                    <i class="fa fa-edit"></i>
                                </a>
                                    <a onclick="fireDeleteEvent({{ $answer->id }})" type="button"
                                       title="{{ trans('dashboard.delete') }}" data-toggle="tooltip"
                                       class="btn btn-danger btn-sm text-white"><i class="fas fa-trash-alt"></i></a>

                                    <form action="{{ route('admin.fatwa.answers.destroy', $answer->id) }}" method="POST"
                                          id="form-{{ $answer->id }}">
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

                    url: '{{ route('admin.fatwa.change-status') }}',

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
