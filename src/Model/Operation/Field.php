<?php

namespace Re2bit\Generator\Model\Operation;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;
use Re2bit\Generator\Model\Translation;
use Re2bit\Generator\Model\Validator;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Rene Gerritsen <rene.gerritsen@me.com>
 */
class Field extends AbstractField
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @Serializer\Type("string")
     */
    public $name;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Serializer\Type("string")
     */
    public $type;

    /**
     * @var ArrayCollection<int, Validator>
     * @Assert\Valid()
     * @Serializer\Type("ArrayCollection<Re2bit\Generator\Model\Validator>")
     */
    public $validators;

    /**
     * @var bool
     * @Assert\Type(type="bool")
     * @Serializer\Type("bool")
     */
    public $nullable;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Serializer\Type("string")
     */
    public $description;

    /**
     * @var ArrayCollection<int, Translation>
     * @Assert\Valid()
     * @Serializer\Type("ArrayCollection<Re2bit\Generator\Model\Translation>")
     */
    public $translations;

    /**
     * @var bool
     * @Assert\Type(type="bool")
     * @Serializer\Type("bool")
     */
    private $disabledInGrid;

    /**
     * Field constructor.
     *
     * @param string                            $name
     * @param string                            $type
     * @param ArrayCollection<int, Validator>   $validators
     * @param bool                              $nullable
     * @param string                            $description
     * @param bool                              $disabledInGrid
     * @param ArrayCollection<int, Translation> $translations
     */
    public function __construct(
        string $name,
        string $type,
        $validators,
        bool $nullable,
        string $description,
        bool $disabledInGrid,
        $translations
    )
    {
        $this->name = $name;
        $this->type = $type;
        $this->validators = $validators;
        $this->nullable = $nullable;
        $this->description = $description;
        $this->translations = $translations;
        $this->disabledInGrid = $disabledInGrid;
    }

    /**
     * @return bool
     */
    public function isId() : bool
    {
        return $this->type === 'pk';
    }
}
