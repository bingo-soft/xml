<?php

namespace Xml\Type\Reference;

use Xml\Impl\ModelBuildOperationInterface;

interface ElementReferenceCollectionBuilderInterface extends ModelBuildOperationInterface
{
    public function build(): ElementReferenceCollectionInterface;
}
