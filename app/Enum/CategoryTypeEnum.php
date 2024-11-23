<?php

namespace App\Enum;

enum CategoryTypeEnum: string
{
    public const COURSE = 'course';
    public const BOOK = 'book';

    public static function values(): array
    {
        return [
            self::COURSE,
            self::BOOK,
        ];
    }
}
