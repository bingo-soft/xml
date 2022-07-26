<?php

namespace Xml\Type\Reference;

interface AttributeReferenceBuilderInterface extends ReferenceBuilderInterface
{
    public function build(): AttributeReferenceInterface;
}
