<?php

namespace Re2bit\Generator\Model\Operation;

/**
 * @author Rene Gerritsen <rene.gerritsen@me.com>
 */
class Type
{
    public const MULTI_RESOURCE = 'multi_resource';
    public const SINGLE_RESOURCE = 'single_resource';

    /**
     * @return array<string>
     */
    public static function validValues(): array
    {
        return [
            self::MULTI_RESOURCE,
            //self::SINGLE_RESOURCE,
        ];
    }
}
