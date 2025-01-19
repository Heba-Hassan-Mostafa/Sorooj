@extends('admin.layouts.master')
@section('title')
    {{ trans('dashboard.sidebar.contacts') }}
@endsection
@section('content')
    <h4 class="py-3">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/
            </span>
        </a>
        {{ trans('dashboard.sidebar.contacts') }}
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
                    <th>{{ trans('dashboard.admins.message') }}</th>
                    <th>{{trans('dashboard.admins.message_type')}}</th>
                    <th>{{ trans('dashboard.created_at') }}</th>
                    <th>{{ trans('dashboard.options') }}</th>

                </tr>
                </thead>
                <tbody>
                @foreach ($contacts as $contact)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $contact->name }}</td>
                        <td>{{ $contact->email }}</td>
                        <td>{{ $contact->mobile }}</td>
                        <td style="width:200px">{{ \Illuminate\Support\Str::limit($contact->message, 100) }}</td>
                        <td>{{ __($contact->type) }}</td>
                        <td>{{ $contact->created_at->format('Y-m-d') }}</td>

                        <td>
                            <div class="m-2">
                                <button class="btn btn-warning btn-sm text-white" data-bs-toggle="modal"
                                        data-bs-target="#modalCenter-{{ $contact->id }}">
                                    <i class="fa fa-eye"></i>
                                    <span class="text"></span>
                                </button>
                                    <a onclick="fireDeleteEvent({{ $contact->id }})" type="button"
                                       title="{{ trans('dashboard.delete') }}" data-toggle="tooltip"
                                       class="btn btn-danger btn-sm text-white"><i class="fas fa-trash-alt"></i></a>

                                    <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST"
                                          id="form-{{ $contact->id }}">
                                        @csrf
                                        @method('Delete')
                                    </form>
                            </div>
                        </td>

                    </tr>
                    <!-- Modal -->
                   @include('admin.contacts.showContactUsModal')
                    <!-- modal -->
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
