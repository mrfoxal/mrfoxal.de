<?php

namespace app\enums;

/**
 * YesNo enumerable class
 */
class YesNo extends BasicEnum
{
    const __default = self::NO;

    public const NO = 0;
    public const YES = 1;

    protected static function labels(): array
    {
        return [
            self::NO  => 'Nicht anzeigen',
            self::YES => 'Anzeigen',
        ];
    }
}
