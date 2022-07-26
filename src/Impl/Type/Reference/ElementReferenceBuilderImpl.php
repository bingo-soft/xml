<?php

namespace Xml\Impl\Type\Reference;

use Xml\Impl\Type\Child\ChildElementImpl;
use Xml\Type\Reference\{
    ElementReferenceInterface,
    ElementReferenceBuilderInterface
};

class ElementReferenceBuilderImpl extends ElementReferenceCollectionBuilderImpl implements ElementReferenceBuilderInterface
{
    public function __construct(
        string $childElementType,
        string $referenceTargetClass,
        ChildElementImpl $child
    ) {
        parent::__construct($childElementType, $referenceTargetClass, $child);
        $this->elementReferenceCollectionImpl = new ElementReferenceImpl($child);
    }

    public function build(): ElementReferenceInterface
    {
        return $this->elementReferenceCollectionImpl;
    }
}
