<?php

namespace Re2bit\Generator\Model;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Rene Gerritsen <rene.gerritsen@me.com>
 */
class Namensraum extends AbstractModel
{
    /**
     * @Assert\Type("string")
     * @Assert\NotBlank()
     * @Serializer\Type("string")
     */
    public string $name;

    /**
     * @Assert\Type("bool")
     * @Assert\NotNull()
     * @Serializer\Type("bool")
     */
    public bool $useNamespace;

    /**
     * @var ArrayCollection<int, Module>
     * @Assert\Valid()
     * @Serializer\Type("ArrayCollection<Re2bit\Generator\Model\Module>")
     */
    public ArrayCollection $modules;

    /**
     * @Assert\Valid()
     */
    private Associations $associationCollection;

    /**
     * Namensraum constructor.
     *
     * @param string                       $name
     * @param ArrayCollection<int, Module> $modules
     */
    public function __construct(string $name, ArrayCollection $modules)
    {
        $this->name = $name;
        $this->modules = $modules;
        $this->init();
    }

    /**
     * @Serializer\PostDeserialize()
     */
    public function init(): void
    {
        $this->initNamespace();
        $this->initAssociations();
    }

    /**
     * Associates the Namespace to each Module
     */
    private function initNamespace(): void
    {
        $this->modules->map(function (Module $module) {
            $module->namespace = $this;
        });
    }

    private function initAssociations(): void
    {
        $this->associationCollection = new Associations();
        $this->modules->map(function (Module $module) {
            $module->resources->map(function (ResourceModel $resource) use ($module) {
                $resource->associations->map(function (Association $association) use ($module, $resource) {
                    $association->module = $module;
                    $association->resource = $resource;
                    $this->associationCollection->addAssociation($association);
                });
            });
        });
    }
}
