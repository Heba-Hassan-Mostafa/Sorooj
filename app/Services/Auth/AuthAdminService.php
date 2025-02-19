<?php

namespace App\Services\Auth;

use App\Exceptions\Api\Auth\AuthException;
use App\Http\Requests\Api\Auth\ForgetPasswordDashboardRequest;
use App\Http\Requests\Api\Auth\LoginDashboardRequest;
use App\Http\Requests\Api\Auth\RegisterAdminRequest;
use App\Http\Requests\Api\Auth\ResetPasswordRequest;
use App\Http\Requests\Api\Auth\VerifyOTPRequest;
use App\Services\Auth\AuthAbstract;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class AuthAdminService extends AuthAbstract
{
    public function __construct()
    {
        parent::__construct(new User());
    }

    /**
     * Login
     */
    public function login(FormRequest $request, $abilities = null)
    {
        if (!($request instanceof LoginDashboardRequest)) {
            throw AuthException::wrongImplementation(['wrong_implementation' => [__('Wrong Implementation')]]);
        }

        $request->authenticate();
        $user = $request->user();

        if ($this->loginRequireSendOTP) {
            tap($user)->update([
                'email_verified_at' => NULL,
            ])->fresh();
            return $this->handelOTPMethod($user);
        }
        return $user;
    }


    public function forgetPassword(FormRequest $request, $abilities = null)
    {
        if (!($request instanceof ForgetPasswordDashboardRequest)) {
            throw AuthException::wrongImplementation(['wrong_implementation' => [__('Wrong Implementation')]]);
        }

        $user = $this->model::whereEmail($request->email)->firstOrFail();
        if (is_null($user)) {
            throw AuthException::userNotFound(['unauthorized' => [__("Unauthorized")]]);
        }
        tap($user)->update([
            'email_verified_at' => NULL,
        ])->fresh();
        return $this->handelMailOTP($user);
    }

    public function resentOTP(string $email)
    {
        // Find the user by email
        $user = User::where('email', $email)->first();

        if (!$user) {
            throw new \Exception('User not found');
        }

        return $this->handelMailOTP($user);

    }

    public function register(FormRequest $request, $abilities = null): User
    {
        if (!($request instanceof RegisterAdminRequest)) {
            throw AuthException::wrongImplementation('wrong_implementation**' . __("Failed Operation"));
        }

        $data = $request->validated();
        $user = User::create($data);
        if (!$user->wasRecentlyCreated) {
            throw AuthException::userFailedRegistration('genration_failed**' . __("Failed Operation"));
        }
        $user->access_token = $user->createToken('snctumToken', $abilities ?? [], now()->addHours(1))->plainTextToken;
        return $this->handelMailOTP($user);
    }
}
