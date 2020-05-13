<?php

namespace Re2bit\Generator\Model;

use JMS\Serializer\Annotation as Serializer;
use Re2bit\Generator\Model\Association\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author    Rene Gerritsen <rene.gerritsen@me.com>
 */
class Association extends AbstractModel
{
    /**
     * @Serializer\Type("string")
     * @Assert\Choice(callback={"Re2bit\Generator\Model\Association\Type", "validValues"})
     * @Assert\NotBlank()
     */
    public string $type;

    /**
     * @Serializer\Type("string")
     * @Assert\NotBlank()
     */
    public string $target;

    /**
     * @Serializer\Type("bool")
     * @Assert\NotNull()
     */
    public bool $nullable;

    /**
     * @Serializer\Type("string")
     * @Assert\Type("string")
     */
    public string $role;

    /**
     * @Serializer\Type("string")
     * @Assert\Type("string")
     */
    public string $inverse;

    /**
     * @Serializer\Exclude()
     */
    public Module $module;

    /**
     * @Serializer\Exclude()
     */
    public ResourceModel $resource;

    public function getInverse(): string
    {
        return Type::INVERSE[$this->type];
    }

    public function isOneToMany(): bool
    {
        return $this->type === Type::ONE_TO_MANY;
    }

    public function isManyToOne(): bool
    {
        return $this->type === Type::MANY_TO_ONE;
    }
}
