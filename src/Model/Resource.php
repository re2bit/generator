<?php

namespace Re2bit\Generator\Model;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Rene Gerritsen <rene.gerritsen@me.com>
 */
class Resource extends AbstractModel
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @Serializer\Type("string")
     */
    public $name;

    /**
     * @var string
     * @Assert\Choice(callback={"Re2bit\Generator\Model\Resource\Db", "validValues"})
     * @Serializer\Type("string")
     */
    public $db;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Serializer\Type("string")
     */
    public $icon;

    /**
     * @var ArrayCollection|Association[]
     * @Assert\Valid()
     * @Serializer\Type("ArrayCollection<Re2bit\Generator\Model\Association>")
     */
    public $associations;

    /**
     * @var ArrayCollection|Action[]
     * @Assert\Valid()
     * @Serializer\Type("ArrayCollection<Re2bit\Generator\Model\Field>")
     */
    public $fields;

    /**
     * @var ArrayCollection|Action[]
     * @Assert\Valid()
     * @Serializer\Type("ArrayCollection<Re2bit\Generator\Model\Action>")
     */
    public $actions;
}
