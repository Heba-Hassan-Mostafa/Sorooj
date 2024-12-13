<?php

namespace App\Enum;

enum ContactStatusEnum: string
{
    public const ANSWERED = 'answered';
    public const UNANSWERED = 'unanswered';


    public static function values(): array
    {
        return [
            self::ANSWERED,
            self::UNANSWERED,

        ];
    }
}
