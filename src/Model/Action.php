<?php

namespace Re2bit\Generator\Model;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Rene Gerritsen <rene.gerritsen@me.com>
 */
class Action extends AbstractModel
{
    /**
     * @Serializer\Type("string")
     * @Assert\Choice(callback={"Re2bit\Generator\Model\Action\Type", "validValues"})
     * @Assert\NotBlank()
     */
    public string $type;

    /**
     * @Serializer\Type("string")
     * @Assert\NotBlank(allowNull=true)
     */
    public string $path;
}
