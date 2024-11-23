<?php

namespace App\Exceptions\Api\Auth;

use App\Exceptions\Api\Auth\ApiBaseException;

class AuthException extends ApiBaseException
{
    public static function userNotFound($errors, $code = null)
    {
        return new self($errors, __("User Data Not Found"), $code ?? 404);
    }

    public static function otpNotGenerated($errors, $code = null)
    {
        return new self($errors, __("Failed Operation"), $code ?? 500);
    }

    public static function userFailedRegistration($errors, $code = null)
    {
        return new self($errors, __("Failed Operation"), $code ?? 500);
    }

    public static function accountStatusDeactive($errors, $code = null)
    {
        return new self($errors, __("Failed Operation"), $code ?? 401);
    }

    public static function userNotActive($errors, $code = null)
    {
        return new self($errors, __("Your account is deactivated, please contact the admin"), $code ?? 401);
    }

    public static function userNotVerified($errors, $code = null)
    {
        return new self($errors, __("Your account is not verified, please use otp to verify your account"), $code ?? 401);
    }
}
