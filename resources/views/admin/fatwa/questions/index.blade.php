@extends('admin.layouts.master')
@section('title')
    {{ trans('dashboard.sidebar.questions') }}
@endsection
@section('content')
    <h4 class="py-3">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/
            </span>
        </a>
        {{ trans('dashboard.sidebar.questions') }}
    </h4>
    <div class="card">
        <div class="table-responsive p-2">
            <table class="myDatatable table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('dashboard.fatwa.user_name') }}</th>
                    <th>{{ trans('dashboard.fatwa.user_email') }}</th>
                    <th>{{ trans('dashboard.fatwa.user_phone') }}</th>
                    <th>{{ trans('dashboard.fatwa.created_at') }}</th>
                    <th>{{ trans('dashboard.fatwa.reply') }}</th>
                    <th>{{ trans('dashboard.status') }}</th>
                    <th>{{ trans('dashboard.options') }}</th>

                </tr>
                </thead>
                <tbody>
                @foreach ($questions as $question)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td> {{ $question->name }}</td>
                        <td>{{ $question->user?->email ?? '-----' }}</td>
                        <td>{{ $question->user?->mobile ?? '-----' }}</td>
                        <td>{{ $question->created_at->format('Y-m-d') }}</td>
                        <td>
                                <?php
                                $answer = $question
                                    ->fatwaAnswer()
                                    ->where('fatwa_question_id', $question->id)
                                    ->first();
                                ?>
                            @if ($answer)
                                <div class="btn btn-success-gradient">{{ trans('dashboard.fatwa.reply-done') }}
                                </div>
                            @else
                                <a href="{{ route('admin.fatwa.questions.edit', $question->id) }}"
                                   class="btn btn-info btn-sm text-white"  title="{{ trans('dashboard.edit') }}">
                                    {{ trans('dashboard.fatwa.reply') }}</a>
                            @endif

                        </td>
                        <td>
                            <label class="switch switch-success" for="{{ $question->id }}">
                                <input type="checkbox" class="switch-input status" id="{{ $question->id }}"
                                       data-id="{{ $question->id }}" {{ $question->status == true ? 'checked' : '' }} />
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
                                    <a onclick="fireDeleteEvent({{ $question->id }})" type="button"
                                       title="{{ trans('dashboard.delete') }}" data-toggle="tooltip"
                                       class="btn btn-danger btn-sm text-white"><i class="fas fa-trash-alt"></i></a>

                                    <form action="{{ route('admin.fatwa.questions.destroy', $question->id) }}" method="POST"
                                          id="form-{{ $question->id }}">
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
