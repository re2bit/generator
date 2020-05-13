<?php

namespace Re2bit\Generator\Model;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Rene Gerritsen <rene.gerritsen@me.com>
 */
class ResourceModel extends AbstractModel
{
    /**
     * @Assert\NotBlank()
     * @Serializer\Type("string")
     */
    public string $name;

    /**
     * @Assert\Choice(callback={"Re2bit\Generator\Model\Resource\Db", "validValues"})
     * @Serializer\Type("string")
     */
    public string $db;

    /**
     * @Assert\NotBlank()
     * @Serializer\Type("string")
     */
    public string $icon;

    /**
     * @var ArrayCollection<int, Association>
     * @Assert\Valid()
     * @Serializer\Type("ArrayCollection<Re2bit\Generator\Model\Association>")
     */
    public ArrayCollection $associations;

    /**
     * @var ArrayCollection<int, Action>
     * @Assert\Valid()
     * @Serializer\Type("ArrayCollection<Re2bit\Generator\Model\Field>")
     */
    public ArrayCollection $fields;

    /**
     * @var ArrayCollection<int, Action>
     * @Assert\Valid()
     * @Serializer\Type("ArrayCollection<Re2bit\Generator\Model\Action>")
     */
    public ArrayCollection $actions;
}
