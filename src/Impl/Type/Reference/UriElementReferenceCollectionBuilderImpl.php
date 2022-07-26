<?php

namespace Xml\Impl\Type\Reference;

use Xml\Impl\Type\Child\ChildElementCollectionImpl;

class UriElementReferenceCollectionBuilderImpl extends ElementReferenceCollectionBuilderImpl
{
    public function __construct(
        string $childElementType,
        string $referenceTargetClass,
        ChildElementCollectionImpl $collection
    ) {
        parent::__construct($childElementType, $referenceTargetClass, $collection);
        $this->elementReferenceCollectionImpl = new UriElementReferenceCollectionImpl($collection);
    }
}
