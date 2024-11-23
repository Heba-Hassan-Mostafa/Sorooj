@extends('admin.layouts.master')
@section('title')
    {{ trans('dashboard.admins.edit-admin') }}
@endsection
@section('content')
    <h4 class="py-3 mb-4">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/ </span>
        </a>
        <a href="{{ route('admin.admins.index') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.sidebar.admins') }}/</span>
        </a>
        {{ trans('dashboard.admins.edit-admin') }}
    </h4>
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.admins.update',$admin->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="first_name" class="form-label">{{ trans('dashboard.admins.first_name') }}</label>
                            <input type="text" name="first_name" value="{{ old('first_name',$admin->first_name) }}" class="form-control" />
                            @error('first_name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="last_name" class="form-label">{{ trans('dashboard.admins.last_name') }}</label>
                            <input type="text" name="last_name" value="{{ old('last_name',$admin->last_name) }}" class="form-control" />
                            @error('last_name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 mb-3">
                            <label for="email" class="form-label">{{ trans('dashboard.admins.email') }}</label>
                            <input type="email" name="email" value="{{ old('email',$admin->email) }}" class="form-control" />
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="phone" class="form-label">{{ trans('dashboard.admins.mobile') }}</label>
                            <input type="text" name="mobile" value="{{ old('mobile',$admin->mobile) }}" class="form-control" />
                            @error('mobile')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6 mb-3">
                            <label for="password" class="form-label">{{ trans('dashboard.admins.password') }}</label>
                            <input type="password" name="password" value="" class="form-control" />
                            @error('password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="password_confirmation"
                                   class="form-label">{{ trans('dashboard.admins.password_confirmation') }}</label>
                            <input type="password" name="password_confirmation" value=""
                                   class="form-control" />
                            @error('password_confirmation')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label for="avatar" class="form-label">{{ trans('dashboard.image') }}</label>
                            <input type="file" name="avatar" class="form-control" />
                            @error('avatar')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                            @if (!empty($admin->avatar))
                                <img src="{{ asset($admin->avatar) }}" style="width: 100px;height:100px;padding-top:10px"  alt=""/>
                            @endif
                        </div>

                        <div class="col-12 mb-3">
                            <label for="roles" class="form-label">{{ trans('dashboard.admins.admin-role') }}</label>
                            <select name="roles[]" class="form-control select2" multiple="multiple">
                                @forelse($roles as $role)
                                    <option value="{{ $role->id }}" {{ in_array($role->id , $userRole)?'selected':'' }}>{{ $role->name }}</option>
                                @empty
                                @endforelse
                            </select>
                            @error('roles')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">{{ trans('dashboard.save') }} </button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(function() {

            //select2 with search
            function matchStart(params, data) {
                // If there are no search terms, return all of the data
                if ($.trim(params.term) === '') {
                    return data;
                }

                // Skip if there is no 'children' property
                if (typeof data.children === 'undefined') {
                    return null;
                }

                // `data.children` contains the actual options that we are matching against
                var filteredChildren = [];
                $.each(data.children, function(idx, child) {
                    if (child.text.toUpperCase().indexOf(params.term.toUpperCase()) == 0) {
                        filteredChildren.push(child);
                    }
                });

                // If we matched any of the timezone group's children, then set the matched children on the group
                // and return the group object
                if (filteredChildren.length) {
                    var modifiedData = $.extend({}, data, true);
                    modifiedData.children = filteredChildren;

                    // You can return modified objects from here
                    // This includes matching the `children` how you want in nested data sets
                    return modifiedData;
                }

                // Return `null` if the term should not be displayed
                return null;
            }

            $(".select2").select2({
                tags: true,
                closeOnSelect: false,
                minimumResultsForSearch: Infinity,
                matcher: matchStart
            });
        });
    </script>
@endsection
