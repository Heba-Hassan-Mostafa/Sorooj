<?php

namespace App\Enum;

enum CategoryTypeEnum: string
{
    public const COURSE = 'course';
    public const BOOK = 'book';
    public const BLOG = 'blog';

    public const VIDEO = 'video';

    public const AUDIO = 'audio';


    public static function values(): array
    {
        return [
            self::COURSE,
            self::BOOK,
            self::BLOG,
            self::VIDEO,
            self::AUDIO
        ];
    }
}
