<?php

namespace Xml\Type\Child;

use Xml\Instance\ModelElementInstanceInterface;
use Xml\Type\Reference\ElementReferenceBuilderInterface;

interface ChildElementBuilderInterface extends ChildElementCollectionBuilderInterface
{
    public function immutable(): ChildElementBuilderInterface;

    public function required(): ChildElementBuilderInterface;

    public function minOccurs(int $i): ChildElementBuilderInterface;

    public function maxOccurs(int $i): ChildElementBuilderInterface;

    public function build(): ChildElementInterface;

    /**
     * @param mixed $referenceTargetType
     */
    public function qNameElementReference($referenceTargetType): ElementReferenceBuilderInterface;

    /**
     * @param mixed $referenceTargetType
     */
    public function idElementReference($referenceTargetType): ElementReferenceBuilderInterface;

    /**
     * @param mixed $referenceTargetType
     */
    public function uriElementReference($referenceTargetType): ElementReferenceBuilderInterface;
}
