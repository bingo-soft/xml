<?php

namespace Xml\Type\Child;

use Xml\Instance\ModelElementInstanceInterface;

interface SequenceBuilderInterface
{
    /**
     * @param mixed $childElementType
     */
    public function element($childElementType): ChildElementBuilderInterface;

    /**
     * @param mixed $childElementType
     */
    public function elementCollection($childElementType): ChildElementCollectionBuilderInterface;
}
