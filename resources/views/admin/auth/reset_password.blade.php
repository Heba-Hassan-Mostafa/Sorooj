@extends('admin.auth.auth_layout')
@section('title')
    Reset Password
@endsection
@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <!-- Reset Password -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-4 mt-2">
                            <img src="{{asset('assets/admin/images/logo.png')}}" alt="logo" style="width: 100px">

                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-1 pt-2"> تغيير كلمة المرور 🔒</h4>
                        <p class="mb-4"> <span class="fw-medium">{{ session('email') }}</span></p>
                        <form id="formAuthentication" action="{{ route('admin.reset.password') }}" method="POST">
                            @csrf
                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="password"> كلمة المرور</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="confirm-password"> تأكيد كلمة المرور</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="confirm-password" class="form-control" name="password_confirmation"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    @error('password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <button class="btn btn-primary d-grid w-100 mb-3"> تغيير كلمة المرور</button>

                        </form>
                    </div>
                </div>
                <!-- /Reset Password -->
            </div>
        </div>
    </div>
@endsection
