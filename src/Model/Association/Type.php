<?php

namespace Re2bit\Generator\Model\Association;

/**
 * @author Rene Gerritsen <rene.gerritsen@me.com>
 */
class Type
{
    public const ONE_TO_MANY   = 'one_to_many';
    public const MANY_TO_ONE  = 'many_to_one';
    public const MANY_TO_MANY = 'many_to_many';

    public const INVERSE = [
        self::ONE_TO_MANY  => self::MANY_TO_ONE,
        self::MANY_TO_ONE  => self::ONE_TO_MANY,
        self::MANY_TO_MANY => self::MANY_TO_MANY,
    ];

    /**
     * @return array<string>
     */
    public static function validValues(): array
    {
        return [
            self::MANY_TO_ONE,
            self::ONE_TO_MANY,
            self::MANY_TO_MANY,
        ];
    }
}
