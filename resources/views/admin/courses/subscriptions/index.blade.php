@extends('admin.layouts.master')
@section('title')
    {{ trans('dashboard.sidebar.courses-subscriptions') }}
@endsection
@section('content')
    <h4 class="py-3">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/
            </span>
        </a>
        {{ trans('dashboard.sidebar.courses-subscriptions') }}
    </h4>

    <div class="card mt-4">
        <div class="table-responsive p-2">
            <table class="myDatatable table table-bordered">
                <thead>
                <tr class="mainBtnStyle text-white">
                    <th class="text-white ">#</th>
                    <th class="text-white ">{{ trans('dashboard.courses.subscriptions') }}</th>
                    <th class="text-white ">{{ trans('dashboard.courses.course_name') }}</th>
                    <th class="text-white ">{{ trans('dashboard.subscription_at') }}</th>

                </tr>
                </thead>
                <tbody>
                @foreach ($subscriptions as $subscription)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $subscription->user?->fullName() }}</td>
                        <td>{{ $subscription->course?->course_name }}</td>
                        <td>{{ $subscription->created_at->format('Y-m-d') }}</td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
