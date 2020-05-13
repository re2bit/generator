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
     */
    public string $type;

    /**
     * @Serializer\Type("boolean")
     * @Assert\IsTrue()
     */
    public bool $async;

    /**
     * @Serializer\Type("string")
     * @Assert\NotBlank()
     */
    public string $resource;

    /**
     * @Assert\NotBlank()
     * @Serializer\Type("string")
     */
    public string $name;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Serializer\Type("string")
     */
    public string $description;

    /**
     * @var ArrayCollection<int, Translation>
     * @Assert\Valid()
     * @Serializer\Type("ArrayCollection<Re2bit\Generator\Model\Translation>")
     */
    public ArrayCollection $translations;
}
