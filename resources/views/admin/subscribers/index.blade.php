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
        {{ trans('dashboard.sidebar.subscribers') }}
    </h4>
    <div class="card">
        <div class="table-responsive p-2">
            <table class="myDatatable table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('dashboard.admins.email') }}</th>
                    <th>{{ trans('dashboard.options') }}</th>

                </tr>
                </thead>
                <tbody>
                @foreach ($subscribers as $subscriber)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $subscriber->email }}</td>
                        <td>
                            <div class="m-2">
                                    <a onclick="fireDeleteEvent({{ $subscriber->id }})" type="button"
                                       title="{{ trans('dashboard.delete') }}" data-toggle="tooltip"
                                       class="btn btn-danger btn-sm text-white"><i class="fas fa-trash-alt"></i></a>
                                    <form action="{{ route('admin.subscribers.destroy', $subscriber->id) }}" method="POST"
                                          id="form-{{ $subscriber->id }}">
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
