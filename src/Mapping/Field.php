<?php

namespace Re2bit\Generator\Mapping;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use DomainException;
use Re2bit\Generator\Model\Field as BaseField;
use Re2bit\Generator\Model\Validator;

/**
 * @author  Rene Gerritsen <rene.gerritsen@me.com>
 */
class Field
{
    public static function mapForPHP(string $type): string
    {
        $types = [
            'pk'      => 'int',
            'string'  => 'string',
            'bool'    => 'bool',
            'integer' => 'int',
            'float'   => 'float',
            'date'    => 'DateTimeImmutable',
            'id'      => 'int',
        ];

        return $types[$type];
    }

    public static function mapForPhpCast(string $type): string
    {
        $types = [
            'pk'      => '(int)',
            'string'  => '(string)',
            'bool'    => '(bool)',
            'integer' => '(int)',
            'float'   => '(float)',
            'date'    => '',
            'id'      => '(int)',
        ];

        return $types[$type];
    }

    public static function mapForExtJs(string $type): string
    {
        $types = [
            'pk'      => 'int',
            'string'  => 'string',
            'bool'    => 'bool',
            'integer' => 'int',
            'float'   => 'float',
            'date'    => 'date',
            'id'      => 'int',
        ];

        return $types[$type];
    }

    public static function mapForExtJsForm(string $type): string
    {
        $types = [
            'string'  => 'textfield',
            'bool'    => 'checkboxfield',
            'integer' => 'numberfield',
            'float'   => 'numberfield',
            'date'    => 'datefield',
            'id'      => 'numberfield',
        ];

        return $types[$type];
    }

    public static function mapForJms(string $type): string
    {
        $types = [
            'pk'      => 'int',
            'integer' => 'int',
            'id'      => 'int',
            'string'  => 'string',
            'bool'    => 'bool',
            'float'   => 'float',
            'date'    => "DateTimeImmutable<'Y-m-d'>",
        ];

        return $types[$type];
    }

    public static function mapForMysql(string $type): string
    {
        $types = [
            'pk'      => 'INT',
            'string'  => 'VARCHAR(256)',
            'bool'    => 'tinyint',
            'integer' => 'INT',
            'float'   => 'FLOAT',
            'date'    => 'DATETIME',
            'id'      => 'INT',
        ];

        return $types[$type];
    }

    public static function mapForXType(string $type): string
    {
        $types = [
            'pk'      => 'numbercolumn',
            'integer' => 'numbercolumn',
            'id'      => 'numbercolumn',
            'string'  => 'gridcolumn',
            'bool'    => 'booleancolumn',
            'float'   => 'numbercolumn',
            'date'    => 'datecolumn',
        ];

        return $types[$type];
    }

    public static function mapForGridFormat(string $type): string
    {
        $types = [
            'pk'      => "format:'0',",
            'integer' => "format:'0',",
            'id'      => "format:'0',",
            'string'  => '',
            'bool'    => '',
            'float'   => "",
            'date'    => "",
        ];

        return $types[$type];
    }

    public static function mapForFormFormat(string $type): string
    {
        $types = [
            'pk'      => '',
            'integer' => '',
            'id'      => '',
            'string'  => '',
            'bool'    => '',
            'float'   => "",
            'date'    => "submitFormat: 'Y-m-d',",
        ];

        return $types[$type];
    }

    public static function mapForGridFilter(string $type): string
    {
        $types = [
            'pk'      => 'number',
            'integer' => 'number',
            'id'      => 'number',
            'string'  => 'string',
            'bool'    => 'boolean',
            'float'   => 'number',
            'date'    => 'date',
        ];

        return $types[$type];
    }

    public static function mapForDoctrine(string $type): string
    {
        $types = [
            'pk'      => 'integer',
            'integer' => 'integer',
            'id'      => 'integer',
            'string'  => 'string',
            'bool'    => 'boolean',
            'float'   => 'float',
            'date'    => 'datetime_immutable',
        ];

        return $types[$type];
    }

    public static function mapForHoboValidator(string $type): string
    {
        switch ($type) {
            case 'string':
                return '@StringAnnotation()';
            case 'integer':
            case 'pk':
            case 'id':
                return '@IntegerAnnotation()';
            case "date":
                return '@DateTimeAnnotation()';
            case "float":
                return '@NumericAnnotation()';
            case "bool":
                return '@BoolAnnotation()';
            case "null":
                return '@NullableAnnotation()';
        }
        throw new DomainException('Invalid Type given', 1589271644693);
    }

    public static function mapForFakerType(string $type): string
    {
        $types = [
            'pk'      => 'randomNumber',
            'integer' => 'randomNumber',
            'id'      => 'randomNumber',
            'string'  => 'word',
            'bool'    => 'boolean',
            'float'   => 'randomFloat',
            'date'    => 'date',
        ];

        return $types[$type];
    }

    /**
     * @param ArrayCollection<int, BaseField> $fields
     *
     * @return Collection<int, BaseField>
     */
    public static function removePk(ArrayCollection $fields): Collection
    {
        return $fields->filter(function (BaseField $field) {
            return $field->type !== 'pk';
        });
    }

    /**
     * @param ArrayCollection<int, BaseField> $fields
     *
     * @return Collection<int, BaseField>
     */
    public static function removeDates(ArrayCollection $fields): Collection
    {
        return $fields->filter(function (BaseField $field) {
            return $field->name !== 'created' && $field->name !== 'updated';
        });
    }

    /**
     * @param ArrayCollection<int, Validator> $validators
     *
     * @return Collection<int, Validator>
     */
    public static function removeNullable(ArrayCollection $validators): Collection
    {
        return $validators->filter(function (Validator $validator) {
            return $validator->type !== 'null';
        });
    }
}
