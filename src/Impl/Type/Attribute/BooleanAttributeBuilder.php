<?php

namespace Xml\Impl\Type\Attribute;

use Xml\Impl\Type\ModelElementTypeImpl;

class BooleanAttributeBuilder extends AttributeBuilderImpl
{
    public function __construct(string $attributeName, ModelElementTypeImpl $modelType)
    {
        parent::__construct($attributeName, $modelType, new BooleanAttribute($modelType));
    }
}
