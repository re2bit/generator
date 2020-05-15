<?php

namespace Re2bit\Generator\Model\Module;

/**
 * @author Rene Gerritsen <rene.gerritsen@me.com>
 */
class Layout
{
    public const TAB = 'tab';

    /**
     * @return array<string>
     */
    public static function validValues(): array
    {
        return [
            self::TAB,
        ];
    }
}
