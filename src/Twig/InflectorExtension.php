<?php

namespace Re2bit\Generator\Twig;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Inflector\Inflector;
use Faker\Factory;
use Re2bit\Generator\Mapping\Action;
use Re2bit\Generator\Mapping\Field;
use Re2bit\Generator\Model\Association;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * @author  Rene Gerritsen <rene.gerritsen@me.com>
 */
class InflectorExtension extends AbstractExtension
{
    /**
     * Adds Custom filters to Twig
     * @TODO Refactor. maybe create own filter Classes ?
     * @return array|TwigFilter[]
     */
    public function getFilters()
    {
        return [

            // ---------------------------------------------------------------
            // String Filter
            // ---------------------------------------------------------------
            new TwigFilter(
                'tableize',
                function (string $string) {
                    return Inflector::tableize($string);
                }
            ),
            new TwigFilter(
                'classify',
                function (string $string) {
                    return Inflector::classify($string);
                }
            ),
            new TwigFilter(
                'pluralize',
                function (string $string) {
                    return Inflector::pluralize($string);
                }
            ),
            new TwigFilter(
                'camelize',
                function (string $string) {
                    return Inflector::camelize($string);
                }
            ),


            // ---------------------------------------------------------------
            //Type Mapper
            // ---------------------------------------------------------------
            new TwigFilter(
                'map_mysql',
                function (string $string) {
                    return Field::mapForMysql($string);
                }
            ),
            new TwigFilter(
                'map_jms',
                function (string $string) {
                    return Field::mapForJms($string);
                }
            ),
            new TwigFilter(
                'map_doctrine',
                function (string $string) {
                    return Field::mapForDoctrine($string);
                }
            ),
            new TwigFilter(
                'map_extjs',
                function (string $string) {
                    return Field::mapForExtJs($string);
                }
            ),
            new TwigFilter(
                'map_extjs_form',
                function (string $string) {
                    return Field::mapForExtJsForm($string);
                }
            ),
            new TwigFilter(
                'map_xtype',
                function (string $string) {
                    return Field::mapForXType($string);
                }
            ),
            new TwigFilter(
                'map_grid_filter',
                function (string $string) {
                    return Field::mapForGridFilter($string);
                }
            ),
            new TwigFilter(
                'map_grid_format',
                function (string $string) {
                    return Field::mapForGridFormat($string);
                }
            ),
            new TwigFilter(
                'map_form_format',
                function (string $string) {
                    return Field::mapForFormFormat($string);
                }
            ),
            new TwigFilter(
                'map_php',
                function (string $string) {
                    return Field::mapForPHP($string);
                }
            ),
            new TwigFilter(
                'map_php_cast',
                function (string $string) {
                    return Field::mapForPhpCast($string);
                }
            ),
            new TwigFilter(
                'map_http_method',
                function (string $string) {
                    return Action::mapHttpMethod($string);
                }
            ),
            new TwigFilter(
                'map_hobo_validator',
                function (string $string) {
                    return Field::mapForHoboValidator($string);
                }
            ),


            // ---------------------------------------------------------------
            //Collection Filter
            // ---------------------------------------------------------------
            new TwigFilter(
                'remove_pk',
                function (ArrayCollection $fields) {
                    return Field::removePk($fields);
                }
            ),
            new TwigFilter(
                'remove_nullable',
                function (ArrayCollection $fields) {
                    return Field::removeNullable($fields);
                }
            ),
            new TwigFilter(
                'remove_dates',
                function (ArrayCollection $fields) {
                    return Field::removeDates($fields);
                }
            ),
            new TwigFilter(
                'only_many_to_one',
                function (ArrayCollection $associations) {
                    return $associations->filter(function (Association $association) {
                        return $association->isManyToOne();
                    });
                }
            ),
            new TwigFilter(
                'only_one_to_many',
                function (ArrayCollection $associations) {
                    return $associations->filter(function (Association $association) {
                        return $association->isOneToMany();
                    });
                }
            ),


            // ---------------------------------------------------------------
            //Utilities
            // ---------------------------------------------------------------
            new TwigFilter(
                'fake_value',
                function (string $string) {
                    $faker = Factory::create();
                    $fakeType = Field::mapForFakerType($string);
                    return $faker->{$fakeType};
                }
            ),
            new TwigFilter(
                'lcfirst',
                function (string $string) {
                    return lcfirst($string);
                }
            ),
        ];
    }
}
