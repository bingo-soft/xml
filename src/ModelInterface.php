<?php

namespace Xml;

use Xml\Instance\ModelElementInstanceInterface;
use Xml\Type\ModelElementTypeInterface;

interface ModelInterface
{
    public function getTypes(): array;

    public function getType(?string $instanceClass): ?ModelElementTypeInterface;

    public function getTypeForName(?string $namespaceUri, string $typeName): ?ModelElementTypeInterface;

    public function getModelName(): string;

    public function getActualNamespace(string $alternativeNs): ?string;

    public function getAlternativeNamespace(string $actualNs): ?string;

    public function getAlternativeNamespaces(string $actualNs): array;
}
