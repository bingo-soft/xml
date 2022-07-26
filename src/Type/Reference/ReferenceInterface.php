<?php

namespace Xml\Type\Reference;

use Xml\Instance\ModelElementInstanceInterface;
use Xml\Type\ModelElementTypeInterface;
use Xml\Type\Attribute\AttributeInterface;

interface ReferenceInterface
{
    /**
     * @return mixed
     */
    public function getReferenceIdentifier(ModelElementInstanceInterface $referenceSourceElement);

    /**
     * @return mixed
     */
    public function getReferenceTargetElement(ModelElementInstanceInterface $modelElement);

    /**
     * @param ModelElementInstanceInterface $referenceSourceElement
     * @param mixed $referenceTargetElement
     */
    public function setReferenceTargetElement(
        ModelElementInstanceInterface $referenceSourceElement,
        $referenceTargetElement
    ): void;

    public function getReferenceTargetAttribute(): AttributeInterface;

    public function findReferenceSourceElements(ModelElementInstanceInterface $referenceTargetElement): array;

    public function getReferenceSourceElementType(): ModelElementTypeInterface;
}
