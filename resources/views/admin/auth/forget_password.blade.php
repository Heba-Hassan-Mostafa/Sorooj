@extends('admin.auth.auth_layout')
@section('title')
    Forget Password
@endsection
@section('content')

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <!-- Forgot Password -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-4 mt-2">
                            <img src="{{asset('assets/admin/images/logo.png')}}" alt="logo" style="width: 100px">

                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-1 pt-2"> نسيت كلمة المرور؟ 🔒</h4>
                        <p class="mb-4">أدخل بريدك الإلكتروني وسنرسل لك تعليمات لإعادة تعيين كلمة المرور الخاصة بك</p>
                        <form id="formAuthentication" class="mb-3" action="{{ route('admin.forget.password.submit') }}"
                              method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">البريد الالكتروني</label>
                                <input type="email" class="form-control" id="email" name="email"
                                       placeholder="ادخل البريد الالكتروني" autofocus/>
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button class="btn btn-primary d-grid w-100">ارسل</button>
                        </form>
                        <div class="text-center">
                            <a href="{{ route('admin.login') }}"
                               class="d-flex align-items-center justify-content-center">
                                <i class="ti ti-chevron-left scaleX-n1-rtl"></i>
                                العودة لتسجيل الدخول
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /Forgot Password -->
            </div>
        </div>
    </div>

@endsection
