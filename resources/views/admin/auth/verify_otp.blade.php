@extends('admin.auth.auth_layout')
@section('title')
    Verify OTP
@endsection
@section('content')

    <div class="authentication-wrapper authentication-basic px-4">
        <div class="authentication-inner py-4">
            <!--  Two Steps Verification -->
            <div class="card">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mb-4 mt-2">
                        <a href="index.html" class="app-brand-link gap-2">
                            <img src="{{asset('assets/admin/images/logo.png')}}" alt="logo" style="width: 100px">

                        </a>
                    </div>
                    <!-- /Logo -->
                    <h4 class="mb-1 pt-2"> تحقق 💬</h4>
                    <p class="text-start mb-4">
                        لقد أرسلنا رمز التحقق إلى بريدك الالكترونى . أدخل الرمز في الحقل أدناه.
                        <span class="fw-medium d-block mt-2"></span>
                    </p>
                    <p class="mb-0 fw-medium">اكتب رمز الحماية المكون من 4 أرقام</p>
                    <form id="twoStepsForm" action="{{ route('admin.verify.otp.submit') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <div
                                class="auth-input-wrapper d-flex align-items-center justify-content-sm-between numeral-mask-wrapper"
                                dir="ltr">
                                <input type="text"
                                       class="form-control auth-input h-px-50 text-center numeral-mask mx-1 my-2"
                                       maxlength="1" autofocus oninput="handleInput(event, 'otp1', 'otp2')" dir="ltr"/>
                                <input type="text"
                                       class="form-control auth-input h-px-50 text-center numeral-mask mx-1 my-2"
                                       maxlength="1" id="otp2" oninput="handleInput(event, 'otp2', 'otp3')" dir="ltr"/>
                                <input type="text"
                                       class="form-control auth-input h-px-50 text-center numeral-mask mx-1 my-2"
                                       maxlength="1" id="otp3" oninput="handleInput(event, 'otp3', 'otp4')" dir="ltr"/>
                                <input type="text"
                                       class="form-control auth-input h-px-50 text-center numeral-mask mx-1 my-2"
                                       maxlength="1" id="otp4" oninput="handleInput(event, 'otp4', '')" dir="ltr"/>
                            </div>
                            <!-- Hidden field that will hold the full code -->
                            <input type="hidden" name="code" id="codeInput"/>
                            @error('code')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <button class="btn btn-primary d-grid w-100 mb-3">تحقق</button>

                    </form>
                    <div class="text-center">
                        لم تحصل على الرمز؟
                        <form id="resendOtpForm" action="{{ route('admin.resend.otp') }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden"  name="email" value="{{ session('email') }}"> <!-- Pass the email used during OTP request -->
                            <button type="submit" class="btn btn-link p-0">اعادة الارسال</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- / Two Steps Verification -->
        </div>
    </div>

    <script>
        // Function to handle input entry for moving left to right
        function handleInput(event, currentInputId, nextInputId) {
            const input = event.target;

            // Move to the next input if the current input has a value
            if (input.value.length === 1 && nextInputId) {
                document.getElementById(nextInputId).focus();
            } else if (input.value.length === 0) {
                // Move back when deleting
                const prevInput = input.previousElementSibling;
                if (prevInput) prevInput.focus();
            }

            updateCode();
        }

        // Update hidden input with the full OTP code
        function updateCode() {
            const otpInputs = document.querySelectorAll('.numeral-mask');
            let code = '';
            otpInputs.forEach(input => {
                code += input.value;
            });
            document.getElementById('codeInput').value = code;
        }
    </script>

@endsection
