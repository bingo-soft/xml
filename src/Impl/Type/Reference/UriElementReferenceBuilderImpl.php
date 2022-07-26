<?php

namespace Xml\Impl\Type\Reference;

use Xml\Type\Child\ChildElementInterface;

class UriElementReferenceBuilderImpl extends ElementReferenceBuilderImpl
{
    public function __construct(
        string $childElementType,
        string $referenceTargetClass,
        ChildElementInterface $child
    ) {
        parent::__construct($childElementType, $referenceTargetClass, $child);
        $this->elementReferenceCollectionImpl = new UriElementReferenceImpl($child);
    }
}
