@extends('admin.auth.auth_layout')
@section('title')
    Login
@endsection
@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <!-- Login -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-4 mt-2">
{{--                            <a href="{{route('admin.login')}}" class="app-brand-link gap-2">--}}

                              <img src="{{asset('assets/admin/images/logo.png')}}" alt="logo" style="width: 100px">

{{--                            </a>--}}
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-1 pt-2">مرحبا بك 👋</h4>
                        <p class="mb-4"> قم بتسجيل الدخول </p>

                        <form id="formAuthentication" class="mb-3" action="{{ route('admin.login.submit') }}"
                              method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label"> البريد الالكتروني</label>
                                <input type="text" class="form-control" id="email" name="email"
                                       placeholder="ادخل البريد الالكتروني" autofocus/>
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password"> كلمة المرور</label>
                                    <a href="{{ route('admin.forget.password') }}">
                                        <small> نسيت كلمة المرور؟ </small>
                                    </a>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                           placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                           aria-describedby="password"/>
                                    @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember-me"/>
                                    <label class="form-check-label"
                                           for="remember-me" {{ old('remember') ? 'checked' : '' }}> تذكرني </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">تسجيل الدخول</button>
                            </div>
                        </form>

                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>

@endsection
