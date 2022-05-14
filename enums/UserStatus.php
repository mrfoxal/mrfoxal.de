<?php

namespace app\enums;

/**
 * User Statuses enumerable class
 */
class UserStatus extends BasicEnum
{
    const __default = self::STATUS_NOT_APPROVED;

    public const STATUS_DELETED = 0;
    public const STATUS_NOT_APPROVED = 10;
    public const STATUS_APPROVED = 20;

    protected static function labels(): array
    {
        return [
            self::STATUS_APPROVED => 'Approved',
            self::STATUS_NOT_APPROVED => 'Not approved',
            self::STATUS_DELETED      => 'Deleted',
        ];
    }
}
