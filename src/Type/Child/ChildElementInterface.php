<?php

namespace Xml\Type\Child;

use Xml\Instance\ModelElementInstanceInterface;

interface ChildElementInterface extends ChildElementCollectionInterface
{
    public function setChild(
        ModelElementInstanceInterface $element,
        ModelElementInstanceInterface $newChildElement
    ): void;

    public function getChild(ModelElementInstanceInterface $element): ?ModelElementInstanceInterface;

    public function removeChild(ModelElementInstanceInterface $element): bool;
}
