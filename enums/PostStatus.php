<?php

namespace app\enums;

/**
 * Post Statuses enumerable class
 */
class PostStatus extends BasicEnum
{
    const __default = self::STATUS_DRAFT;

    public const STATUS_DRAFT = 0;
    public const STATUS_PUBLIC = 1;

    protected static function labels(): array
    {
        return [
            self::STATUS_DRAFT  => 'Entwurf',
            self::STATUS_PUBLIC => 'Veröffentlicht',
        ];
    }
}
