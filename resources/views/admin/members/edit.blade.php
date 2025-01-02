@extends('admin.layouts.master')
@section('title')
    {{ trans('dashboard.members.edit-member') }}
@endsection
@section('content')
    <h4 class="py-3 mb-4">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/ </span>
        </a>
        <a href="{{ route('admin.management-members.index') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.sidebar.management-members') }}/</span>
        </a>
        {{ trans('dashboard.members.edit-member') }}
    </h4>
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.management-members.update',$member->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="name" class="form-label">{{ trans('dashboard.members.name') }}</label>
                            <input type="text" name="name" value="{{ old('name',$member->name) }}" class="form-control" />
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="position" class="form-label">{{ trans('dashboard.members.position') }}</label>
                            <input type="text" name="position" value="{{ old('position',$member->position) }}" class="form-control" />
                            @error('position')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label for="avatar" class="form-label">{{ trans('dashboard.image') }}</label>
                            <input type="file" name="avatar" class="form-control" />
                            @error('avatar')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                            @if (!empty($member->avatar))
                                <img src="{{ asset($member->avatar) }}" style="width: 100px;height:100px;padding-top:10px"  alt=""/>
                            @endif
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">{{ trans('dashboard.save') }} </button>
                </form>
            </div>
        </div>
    </div>
@endsection
