<?php

namespace Xml\Type\Child;

use Xml\Instance\ModelElementInstanceInterface;
use Xml\Type\Reference\ElementReferenceCollectionBuilderInterface;

interface ChildElementCollectionBuilderInterface
{
    public function immutable(): ChildElementCollectionBuilderInterface;

    public function required(): ChildElementCollectionBuilderInterface;

    public function minOccurs(int $i): ChildElementCollectionBuilderInterface;

    public function maxOccurs(int $i): ChildElementCollectionBuilderInterface;

    public function build(): ChildElementCollectionInterface;

    /**
     * @param mixed $referenceTargetType
     */
    public function qNameElementReferenceCollection($referenceTargetType): ElementReferenceCollectionBuilderInterface;

    /**
     * @param mixed $referenceTargetType
     */
    public function idElementReferenceCollection($referenceTargetType): ElementReferenceCollectionBuilderInterface;

    /**
     * @param mixed $referenceTargetType
     */
    public function idsElementReferenceCollection($referenceTargetType): ElementReferenceCollectionBuilderInterface;

    /**
     * @param mixed $referenceTargetType
     */
    public function uriElementReferenceCollection($referenceTargetType): ElementReferenceCollectionBuilderInterface;
}
