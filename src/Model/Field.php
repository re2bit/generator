<?php

namespace Re2bit\Generator\Model;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Rene Gerritsen <rene.gerritsen@me.com>
 */
class Field extends AbstractModel
{
    /**
     * @Assert\NotBlank()
     * @Serializer\Type("string")
     */
    public string $name;

    /**
     * @Assert\NotBlank()
     * @Serializer\Type("string")
     */
    public string $type;

    /**
     * @var ArrayCollection<int, Validator>
     * @Assert\Valid()
     * @Serializer\Type("ArrayCollection<Re2bit\Generator\Model\Validator>")
     */
    public ArrayCollection $validators;

    /**
     * @Assert\Type(type="bool")
     * @Serializer\Type("bool")
     */
    public bool $nullable;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Serializer\Type("string")
     */
    public string $description;

    /**
     * @Assert\Type(type="bool")
     * @Serializer\Type("bool")
     */
    public bool $disabledInGrid;

    /**
     * @var ArrayCollection<int, Translation>
     * @Assert\Valid()
     * @Serializer\Type("ArrayCollection<Re2bit\Generator\Model\Translation>")
     */
    public ArrayCollection $translations;

    /**
     * Field constructor.
     *
     * @param string                            $name
     * @param string                            $type
     * @param ArrayCollection<int,Validator>    $validators
     * @param bool                              $nullable
     * @param string                            $description
     * @param bool                              $disabledInGrid
     * @param ArrayCollection<int, Translation> $translations
     */
    public function __construct(
        string $name,
        string $type,
        ArrayCollection $validators,
        bool $nullable,
        string $description,
        bool $disabledInGrid,
        ArrayCollection $translations
    ) {
        $this->name = $name;
        $this->type = $type;
        $this->validators = $validators;
        $this->nullable = $nullable;
        $this->description = $description;
        $this->translations = $translations;
        $this->disabledInGrid = $disabledInGrid;
    }

    public function isId(): bool
    {
        return $this->type === 'pk';
    }
}
