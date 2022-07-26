<?php

namespace Xml\Impl;

use Xml\ModelInterface;

interface ModelBuildOperationInterface
{
    public function performModelBuild(ModelInterface $model): void;
}
