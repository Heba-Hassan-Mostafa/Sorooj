<?php

namespace App\Enum;

enum ContactTypeEnum: string
{
    public const REQUEST = 'request';
    public const INQUIRY = 'inquiry';
    public const SUGGESTION = 'suggestion';
    public const COMPLAINT = 'complaint';

    public const OTHER = 'other';


    public static function values(): array
    {
        return [
            self::REQUEST,
            self::INQUIRY,
            self::SUGGESTION,
            self::COMPLAINT,
            self::OTHER,


        ];
    }
}
