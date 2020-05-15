<?php

namespace Re2bit\Generator\Model\Action;

/**
 * @author Rene Gerritsen <rene.gerritsen@me.com>
 */
class Type
{
    public const INDEX = 'index';
    public const UPDATE = 'update';
    public const SHOW = 'show';
    public const DELETE = 'delete';
    public const CREATE = 'create';
    public const MASS_UPDATE = 'mass_update';
    public const MASS_DELETE = 'mass_delete';

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
