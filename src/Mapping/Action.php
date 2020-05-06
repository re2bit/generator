<?php

namespace Re2bit\Generator\Mapping;

/**
 * @author  Rene Gerritsen <rene.gerritsen@me.com>
 */
class Action
{
    public static function mapHttpMethod(string $type) : string
    {
        $types = [
            "index" => 'GET',
            "update" => 'PUT',
            "show" => 'GET',
            "delete" => 'DELETE',
            "create" => "POST",
            "mass_update" => "PUT",
            "mass_delete" => "DELETE"
        ];

        return $types[$type];
    }
}
