<?php

namespace App\Http\Controllers\DashboardWeb\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\ChangePasswordRequest;
use App\Http\Requests\Api\Auth\ForgetPasswordDashboardRequest;
use App\Http\Requests\Api\Auth\LoginDashboardRequest;
use App\Http\Requests\Api\Auth\ResetPasswordRequest;
use App\Http\Requests\Api\Auth\SendOTPRequest;
use App\Http\Requests\Api\Auth\VerifyOTPRequest;
use App\Http\Resources\Api\Auth\AdminResource;
use App\Models\User;
use App\Services\Auth\AuthAdminService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * @group Dashboard Admin
 *
 * @subGroup Auth
 */
class AuthController extends Controller
{
    private AuthAdminService $authAdminService;

    public function __construct(AuthAdminService $authAdminService)
    {
        $this->authAdminService = $authAdminService;
    }

    // Show login form
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(LoginDashboardRequest $request)
    {
        try {
            $this->authAdminService->login($request);
            return redirect()->route('admin.dashboard')->with('success', __('Logged in successfully'));
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors(['login' => $e->getMessage()]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => __('Invalid credentials.')]);
        }
    }

    // Show forget password form
    public function showForgetPasswordForm()
    {
        return view('admin.auth.forget_password');
    }

    public function forgetPassword(ForgetPasswordDashboardRequest $request)
    {
        try {
            $this->authAdminService->forgetPassword($request);

            // Store the email in the session for use in the OTP form
            session(['email' => $request->email]);

            return redirect()->route('admin.verify.otp')->with('success', __('OTP sent to your email'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['email' => $e->getMessage()]);
        }
    }


    // Show OTP verification form
    public function showVerifyOTPForm()
    {
        return view('admin.auth.verify_otp');
    }

    public function verifyOTP(VerifyOTPRequest $request)
    {
        // Retrieve the user's email from the session
        $email = session('email');

        if (!$email) {
            return redirect()->back()->withErrors(['email' => __('Email not provided.')]);
        }

        // Load the user based on the email stored in the session
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->withErrors(['email' => __('Email not found.')]);
        }

        $user->loadMissing('latestOTPToken');
        if (is_null($user->latestOTPToken)) {
            return redirect()->back()->withErrors(['generation_failed' => __("Failed Operation")]);
        }

        // Check if OTP is still valid
        if ($user->latestOTPToken->isValid()) {
            // Check if the provided code matches
            if ($request->code == $user->latestOTPToken->code) {
                // Deactivate the OTP and mark the email as verified
                $user->latestOTPToken->update(['active' => false]);
                $user->update(['email_verified_at' => now()]);

                // Store the user ID in the session for the reset password process
                session(['reset_user_id' => $user->id]);
                // Redirect to reset password page with success message
                return redirect()->route('admin.reset.password')->with('success', __("OTP verified successfully. You can now reset your password."));
            }

            // If code doesn't match, redirect back with an error
            return redirect()->back()->withErrors(['code' => __("Code Not Matched")]);
        }

        // If OTP is expired, redirect back with an error
        return redirect()->back()->withErrors(['otp' => __("Code Expired")]);
    }

    //resend otp

    public function resendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        if (session('email') !== $request->email) {
            return redirect()->back()->withErrors(['email' => __('Unauthorized')]);
        }

        $this->authAdminService->resentOTP($request->email);
        session()->flash('success', __('A new OTP has been sent to your registered email'));

        return redirect()->route('admin.verify.otp');
    }



    public function showResetPasswordForm()
    {
        return view('admin.auth.reset_password');
    }
    public function resetPassword(ResetPasswordRequest $request)
    {
        // Retrieve the user ID from the session
        $userId = session('reset_user_id');
        if (!$userId) {
            return redirect()->back()->withErrors(['not_found' => __("User not found in session.")]);
        }

        $user = User::find($userId);
        if (is_null($user)) {
            return redirect()->back()->withErrors(['not_found' => __("Data Not Found")]);
        }

        // Hash the new password and save it
        $user->password = $request->password;
        $user->save();

        // Clear the user ID from the session
        session()->forget('reset_user_id');

        session()->flash('success', __("Your password has been successfully reset. You can now log in"));
        return redirect()->route('admin.login');
    }


    public function logout(Request $request)
    {
//        $this->authAdminService->logout($request);
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        session()->flash('success', __("Logged out Successfully"));
        return redirect()->route('admin.login');
    }

}
