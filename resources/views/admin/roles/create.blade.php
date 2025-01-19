@extends('admin.layouts.master')
@section('title')
    {{ trans('dashboard.roles.add-new-role') }}
@endsection
@section('content')

    <h4 class="py-3 mb-4">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/ </span>
        </a>
        <a href="{{route('admin.roles.index')}}">
            <span class="text-muted fw-light">{{trans('dashboard.sidebar.roles')}}/</span>
        </a>
        {{ trans('dashboard.roles.add-new-role') }}
    </h4>
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-body">

                <form class="form-horizontal" action="{{ route('admin.roles.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="card-header">
                            <h5 class="card-title bold brownColor"> {{ trans('dashboard.roles.role-name') }} </h5>
                        </div>
                                <input type="text" name="name" class="form-control" placeholder="{{ trans('dashboard.roles.role-name') }}" value="{{ old('name') }}">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                </div>

                                <hr />
                                <div class="form-group">
                                    <div class="row align-items-center">
                                        <label class="fs-2 col-6 brownColor bold" for="permissions">{{trans('dashboard.roles.permissions')}}</label>
                                        <div class="col-6 d-flex justify-content-end">
                                            <button class="blueBk text-white btnMainStyle" onclick="CheckAll('box1',this)">
                                                {{ trans('dashboard.select-all') }}</button>
                                        </div>
                                    </div>
                                    <input type="checkbox" name="select_all" id="example-select-all" onclick="CheckAll('box1',this)">
                                    <br>
                                   <div class="row  p-3" style="background-color: #f7f7f7 ;border-radius: 10px;
                                                               box-shadow: 1px 1px 20px #f7f7f7;margin: 20px auto;" >
                                       @foreach($permissions as $permissionGroup)
                                           <div class="col-md-6">
                                               <div style="border: 1px solid lightgrey;
                                                            border-style: dotted;
                                                            background: #fff;
                                                            margin: 20px;
                                                            border-radius: 10px;
                                                            padding: 20px 0;">
                                                   <h3 class="mb-4 text-center pb-3 bold brownColor"
                                                       style="border-bottom: 1px solid lightgrey;
                                                                border-bottom-style: dotted;">
                                                       {{ $permissionGroup['name'] }}</h3>
                                                   <div class="row mt-2 mb-5 ps-4 pe-4">
                                                       @foreach($permissionGroup['controls'] as $control)
                                                           <div class="form-group col-md-6 mb-3">
                                                               <input type="checkbox" name="role_permissions[]" value="{{ $control['id'] }}" class="box1">
                                                               <label class="fs-5 mainColor" style="margin-right: 8px">{{ $control['name'] }}</label>
                                                           </div>
                                                       @endforeach
                                                   </div>
                                               </div>
                                             </div>


                                       @endforeach

                                   </div>



                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary mt-5">{{ trans('dashboard.save') }}</button>
                                </div>
                         </div>
                </form>


            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <!-- Add the Bootstrap JavaScript to enable the tabs functionality -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var triggerTabList = [].slice.call(document.querySelectorAll('#languageTabs a'))
            triggerTabList.forEach(function (triggerEl) {
                var tabTrigger = new bootstrap.Tab(triggerEl)
                triggerEl.addEventListener('click', function (event) {
                    event.preventDefault()
                    tabTrigger.show()
                })
            })
        });
    </script>
@endsection
