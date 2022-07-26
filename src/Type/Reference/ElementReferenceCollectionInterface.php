<?php

namespace Xml\Type\Reference;

use Xml\Impl\Instance\ModelElementInstanceImpl;
use Xml\Type\Child\ChildElementCollectionInterface;

interface ElementReferenceCollectionInterface extends ReferenceInterface
{
    public function getReferenceSourceCollection(): ChildElementCollectionInterface;

    public function getReferenceTargetElements(ModelElementInstanceImpl $referenceSourceElement): array;
}
