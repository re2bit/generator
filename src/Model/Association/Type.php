<?php

namespace Re2bit\Generator\Model\Association;

/**
 * @author Rene Gerritsen <rene.gerritsen@me.com>
 */
class Type
{
    /** @var string  */
    const ONE_TO_MANY   = 'one_to_many';
    /** @var string  */
    const MANY_TO_ONE  = 'many_to_one';
    /** @var string  */
    const MANY_TO_MANY = 'many_to_many';

    /** @var string[] */
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
