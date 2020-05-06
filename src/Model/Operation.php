<?php

namespace Re2bit\Generator\Model;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Rene Gerritsen <rene.gerritsen@me.com>
 */
class Operation extends AbstractModel
{
    /**
     * @Serializer\Type("string")
     * @Assert\Choice(callback={"Re2bit\Generator\Model\Operation\Type", "validValues"})
     * @Assert\NotBlank()
     * @var string
     */
    public $type;

    /**
     * @Serializer\Type("boolean")
     * @Assert\IsTrue()
     * @var bool
     */
    public $async;

    /**
     * @Serializer\Type("string")
     * @Assert\NotBlank()
     * @var string
     */
    public $resource;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Serializer\Type("string")
     */
    public $name;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Serializer\Type("string")
     */
    public $description;

    /**
     * @var ArrayCollection&Action[]
     * @Assert\Valid()
     * @Serializer\Type("ArrayCollection<Re2bit\Generator\Model\Translation>")
     */
    public $translations;
}
