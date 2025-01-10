<?php

namespace App\Enum;

enum CommentStatusEnum: string
{
    public const PUBLISHED = 'published';
    public const UNPUBLISHED = 'unpublished';

    public static function values(): array
    {
        return [
            self::PUBLISHED,
            self::UNPUBLISHED
        ];
    }
}
