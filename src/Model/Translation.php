<?php

namespace Re2bit\Generator\Model;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Rene Gerritsen <rene.gerritsen@me.com>
 */
class Translation extends AbstractModel
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @Serializer\Type("string")
     */
    public $language;

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
    public $description;

    /**
     * Translation constructor.
     *
     * @param string $language
     * @param string $name
     * @param string $description
     */
    public function __construct(
        string $language,
        string $name,
        string $description
    ) {
        $this->language = $language;
        $this->name = $name;
        $this->description = $description;}
}
