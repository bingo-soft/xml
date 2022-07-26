<?php

namespace Xml\Type\Reference;

use Xml\Impl\Instance\ModelElementInstanceImpl;
use Xml\Instance\ModelElementInstanceInterface;

interface ElementReferenceInterface extends ElementReferenceCollectionInterface
{
    public function getReferenceSource(
        ModelElementInstanceInterface $referenceSourceParent
    ): ?ModelElementInstanceInterface;

    /**
     * @return mixed
     */
    public function getReferenceTargetElement(
        ModelElementInstanceInterface $modelElement
    );

    /**
     * @param ModelElementInstanceInterface $referenceSourceElement
     * @param mixed $referenceTargetElement
     */
    public function setReferenceTargetElement(
        ModelElementInstanceInterface $referenceSourceElement,
        $referenceTargetElement
    ): void;

    public function clearReferenceTargetElement(ModelElementInstanceImpl $referenceSourceParentElement): void;
}
