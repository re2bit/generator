<?php

namespace Re2bit\Generator\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @author    Rene Gerritsen <rene.gerritsen@me.com>
 *
 * @extends ArrayCollection<int, Association>
 */
class Associations extends ArrayCollection
{
    public function addAssociation(Association $association): void
    {
        $this->add($association);
    }

    /**
     * @Assert\Callback()
     */
    public function isValid(ExecutionContextInterface $context) : void
    {
        $resources = $this->map(function (Association $association) {
           return $association->resource->name . '-' . $association->type;
        });
        $this->map(function (Association $association) use ($resources, $context){
            $inverse = $association->target . '-' . $association->getInverse();
            if(!$resources->contains($inverse)) {
                $context->buildViolation('Association Target for Resource ' . $association->resource->name . ' not present')
                ->atPath($association->resource->name . ' to ' . $association->target)
                ->addViolation();
            };
        });
    }
}


