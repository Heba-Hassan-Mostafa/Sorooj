<?php

namespace App\Enum;

enum CommentStatusEnum: string
{
    public const NEW = 'new';
    public const PUBLISHED = 'published';
    public const UNPUBLISHED = 'unpublished';

    public static function values(): array
    {
        return [
            self::NEW,
            self::PUBLISHED,
            self::UNPUBLISHED
        ];
    }
}
