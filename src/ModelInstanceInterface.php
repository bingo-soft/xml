<?php

namespace Xml;

use Xml\Instance\{
    DomDocumentInterface,
    ModelElementInstanceInterface
};
use Xml\Type\ModelElementTypeInterface;
use Xml\Validation\ValidationResultsInterface;

interface ModelInstanceInterface
{
    public function getDocument(): DomDocumentInterface;

    public function getDocumentElement(): ?ModelElementInstanceInterface;

    public function setDocumentElement(ModelElementInstanceInterface $documentElement): void;

    /**
     * @param mixed $type
     */
    public function newInstance($type, ?string $id): ModelElementInstanceInterface;

    public function getModel(): ModelInterface;

    public function getModelElementById(?string $id): ?ModelElementInstanceInterface;

    /**
     * @param mixed $reference
     */
    public function getModelElementsByType($reference): array;

    public function clone(): ModelInstanceInterface;

    public function validate(array $validators): ValidationResultsInterface;
}
