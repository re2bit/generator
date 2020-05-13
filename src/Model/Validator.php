<?php

namespace Re2bit\Generator\Model;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Rene Gerritsen <rene.gerritsen@me.com>
 */
class Validator extends AbstractModel
{
    /**
     * @Assert\NotBlank()
     * @Serializer\Type("string")
     */
    public string $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }
}
