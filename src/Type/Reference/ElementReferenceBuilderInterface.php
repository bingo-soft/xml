<?php

namespace Xml\Type\Reference;

use Xml\Instance\ModelElementInstanceInterface;

interface ElementReferenceBuilderInterface extends ElementReferenceCollectionBuilderInterface
{
    public function build(): ElementReferenceInterface;
}
