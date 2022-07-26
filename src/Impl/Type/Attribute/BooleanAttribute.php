<?php

namespace Xml\Impl\Type\Attribute;

use Xml\Impl\Util\ModelUtil;
use Xml\Type\ModelElementTypeInterface;

class BooleanAttribute extends AttributeImpl
{
    public function __construct(ModelElementTypeInterface $owningElementType)
    {
        parent::__construct($owningElementType);
    }

    /**
     * @return mixed
     */
    protected function convertXmlValueToModelValue(?string $rawValue)
    {
        return ModelUtil::valueAsBoolean($rawValue);
    }

    /**
     * @param mixed $modelValue;
     */
    protected function convertModelValueToXmlValue($modelValue): string
    {
        return $modelValue === null ? "false" : json_encode($modelValue);
    }
}
