<?php

namespace app\enums;

/**
 * Allow comments enumerable class
 */
class AllowComments extends BasicEnum
{
    const __default = self::YES;

    public const NO = 0;
    public const YES = 1;

    protected static function labels(): array
    {
        return [
            self::NO => 'Nein',
            self::YES => 'Ja',
        ];
    }
}
