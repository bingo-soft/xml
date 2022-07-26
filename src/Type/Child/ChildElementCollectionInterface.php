<?php

namespace Xml\Type\Child;

use Xml\ModelInterface;
use Xml\Type\ModelElementTypeInterface;
use Xml\Instance\ModelElementInstanceInterface;

interface ChildElementCollectionInterface
{
    public function isImmutable(): bool;

    public function getMinOccurs(): int;

    public function getMaxOccurs(): int;

    public function getChildElementType(ModelInterface $model): ModelElementTypeInterface;

    public function getChildElementTypeClass(): string;

    public function getParentElementType(): ModelElementTypeInterface;

    public function get(ModelElementInstanceInterface $modelElement): array;
}
