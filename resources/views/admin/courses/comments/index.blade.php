@extends('admin.layouts.master')
@section('title')
    {{ trans('dashboard.sidebar.courses-comments') }}
@endsection
@section('content')
    <h4 class="py-3">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/
            </span>
        </a>
        {{ trans('dashboard.sidebar.courses-comments') }}
    </h4>
    <div class="card">
        <div class="table-responsive p-2">
            <table class="myDatatable table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('dashboard.courses.client_name') }}</th>
                    <th>{{ trans('dashboard.courses.email') }}</th>
                    <th>{{ trans('dashboard.courses.comment') }}</th>
                    <th>{{ trans('dashboard.courses.stars') }}</th>
                    <th>{{ trans('dashboard.courses.comment-belongs-to') }}</th>
                    <th>{{ trans('dashboard.status') }}</th>
                    <th>{{ trans('dashboard.created_at') }}</th>
                    <th>{{ trans('dashboard.options') }}</th>

                </tr>
                </thead>
                <tbody>
                @foreach ($comments as $comment)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $comment->name }}</td>
                        <td>{{ $comment->user?->email }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($comment->comment, 40) }}</td>
                        <td>
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $comment->stars)
                                    <i class="fas fa-star text-warning"></i>
                                @else
                                    <i class="far fa-star text-muted"></i>
                                @endif
                            @endfor
                        </td>
                        <td>{{ $comment->commentable != '' ? $comment->commentable?->course_name : '----' }}</td>
                        <td>
                            <label class="switch switch-success" for="{{ $comment->id }}">
                                <input type="checkbox" class="switch-input status" id="{{ $comment->id }}"
                                       data-id="{{ $comment->id }}" {{ $comment->is_active == true ? 'checked' : '' }} />
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

                        <td>{{ $comment->created_at->format('Y-m-d') }}</td>
                        <td>
                            <div class="m-2 d-flex">
                                <button class="btn btn-warning btn-sm text-white me-2" data-bs-toggle="modal"
                                        data-bs-target="#modalCenter-{{ $comment->id }}">
                                    <i class="fa fa-eye"></i>
                                    <span class="text"></span>
                                </button>

                                <a onclick="fireDeleteEvent({{ $comment->id }})" type="button"
                                   title="{{ trans('dashboard.delete') }}" data-toggle="tooltip"
                                   class="btn btn-danger btn-sm text-white"><i class="fas fa-trash-alt"></i></a>

                                <form action="{{ route('admin.courses.comments.destroy', $comment->id) }}" method="POST"
                                      id="form-{{ $comment->id }}">
                                    @csrf
                                    @method('Delete')
                                </form>

                            </div>
                        </td>

                    </tr>
                    <!-- Modal -->
                    <div class="modal fade" id="modalCenter-{{ $comment->id }}" tabindex="-1"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5 fw-bold" id="exampleModalLabel">
                                        {{ trans('dashboard.courses.show_comment') }}</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>

                                <div class="modal-body pd-20">
                                    <div class="row">
                                        <div class="col-10">
                                            {{ $comment->comment }}
                                        </div>
                                    </div>

                                </div><!-- modal-body -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">{{ trans('dashboard.close') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- modal -->
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

                    url: '{{ route('admin.courses.comments.change-status') }}',

                    data: {
                        'is_active': status,
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
