<?php

namespace Re2bit\Generator\Model;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Rene Gerritsen <rene.gerritsen@me.com>
 */
class Module extends AbstractModel
{
    /**
     * @var ArrayCollection<int, ResourceModel>
     * @Assert\Valid()
     * @Serializer\Type("ArrayCollection<Re2bit\Generator\Model\ResourceModel>")
     * @Assert\NotNull()
     */
    public ArrayCollection $resources;

    /**
     * @var ArrayCollection<int, Operation>
     * @Assert\Valid()
     * @Serializer\Type("ArrayCollection<Re2bit\Generator\Model\Operation>")
     */
    public ArrayCollection $actions;

    /**
     * @Assert\NotBlank()
     * @Serializer\Type("string")
     */
    public string $name;

    /**
     * @Assert\NotBlank()
     * @Assert\Choice(callback={"Re2bit\Generator\Model\Module\Layout", "validValues"})
     * @Serializer\Type("string")
     */
    public string $layout;

    /** @var Namensraum */
    public Namensraum $namespace;

    /**
     * Module constructor.
     *
     * @param string                              $name
     * @param ArrayCollection<int, ResourceModel> $resources
     * @param ArrayCollection<int, Operation>     $operations
     */
    public function __construct(
        string $name,
        ArrayCollection $resources,
        ArrayCollection $operations
    ) {
        $this->resources = $resources;
        $this->actions = $operations;
        $this->name = $name;
    }

    /**
     * @Serializer\PostDeserialize()
     * @internal
     */
    public function postDeserialize(): void
    {
        $this->resources = $this->resources ?? new ArrayCollection();
        $this->actions = $this->actions ?? new ArrayCollection();
    }
}
