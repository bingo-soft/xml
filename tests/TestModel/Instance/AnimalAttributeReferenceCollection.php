<?php

namespace Tests\Xml\TestModel\Instance;

use Xml\Instance\ModelElementInstanceInterface;
use Xml\Impl\Type\Attribute\AttributeImpl;
use Xml\Type\Reference\AttributeReferenceCollection;

class AnimalAttributeReferenceCollection extends AttributeReferenceCollection
{
    public function __construct(AttributeImpl $referenceSourceAttribute)
    {
        parent::__construct($referenceSourceAttribute);
    }

    protected function getTargetElementIdentifier(ModelElementInstanceInterface $referenceTargetElement): string
    {
        return $referenceTargetElement->getId();
    }
}
