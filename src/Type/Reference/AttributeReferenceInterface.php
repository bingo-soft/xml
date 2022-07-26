<?php

namespace Xml\Type\Reference;

use Xml\Type\Attribute\AttributeInterface;
use Xml\Instance\ModelElementInstanceInterface;

interface AttributeReferenceInterface extends ReferenceInterface
{
    public function getReferenceSourceAttribute(): AttributeInterface;
}
