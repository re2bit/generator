<?php

namespace Re2bit\Generator\Model\Action;

/**
 * @author Rene Gerritsen <rene.gerritsen@me.com>
 */
class Type
{
    const INDEX = 'index';
    const UPDATE = 'update';
    const SHOW = 'show';
    const DELETE = 'delete';
    const CREATE = 'create';
    const MASS_UPDATE = 'mass_update';
    const MASS_DELETE = 'mass_delete';

    /**
     * @return array<string>
     */
    public static function validValues(): array
    {
        return [
            self::INDEX,
            self::UPDATE,
            self::SHOW,
            self::DELETE,
            self::CREATE,
            self::MASS_UPDATE,
            self::MASS_DELETE,
        ];
    }
}
