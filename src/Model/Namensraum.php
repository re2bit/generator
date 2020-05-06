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
     * @var string
     * @Assert\Type("string")
     * @Assert\NotBlank()
     * @Serializer\Type("string")
     */
    public $name;

    /**
     * @var bool
     * @Assert\Type("bool")
     * @Assert\NotNull()
     * @Serializer\Type("bool")
     */
    public $useNamespace;

    /**
     * @var Module[]|ArrayCollection
     * @Assert\Valid()
     * @Serializer\Type("ArrayCollection<Re2bit\Generator\Model\Module>")
     */
    public $modules;

    /**
     * @Assert\Valid()
     * @var Associations|ArrayCollection|Association[]
     */
    private $associationCollection;

    /**
     * Namensraum constructor.
     *
     * @param string                   $name
     * @param ArrayCollection|Module[] $modules
     */
    public function __construct(string $name, ArrayCollection $modules)
    {
        $this->name = $name;
        $this->modules = $modules;
        $this->init();
    }

    /**
     * @Serializer\PostDeserialize()
     * @return void
     */
    public function init() : void
    {
        $this->initNamespace();
        $this->initAssociations();
    }

    /**
     * Associates the Namespace to each Module
     *
     * @return void
     */
    private function initNamespace() : void
    {
        $this->modules->map(function (Module $module)
        {
            $module->namespace = $this;
        });
    }

    private function initAssociations()
    {
        $this->associationCollection = new Associations();
        $this->modules->map(function (Module $module)
        {
            $module->resources->map(function (Resource $resource) use ($module)
            {
                $resource->associations->map(function (Association $association) use ($module, $resource)
                {
                    $association->module = $module;
                    $association->resource = $resource;
                    $this->associationCollection->addAssociation($association);
                });
            });
        });
    }
}
