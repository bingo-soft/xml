<?php

namespace Xml\Type;

use Xml\Instance\ModelElementInstanceInterface;
use Xml\Impl\Instance\ModelTypeInstanceContext;

interface ModelTypeInstanceProviderInterface
{
    public function newInstance(ModelTypeInstanceContext $instanceContext): ModelElementInstanceInterface;
}
