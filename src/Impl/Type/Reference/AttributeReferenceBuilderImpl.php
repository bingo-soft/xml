<?php

namespace Xml\Impl\Type\Reference;

use Xml\ModelInterface;
use Xml\Exception\ModelException;
use Xml\Impl\ModelBuildOperationInterface;
use Xml\Impl\Type\Attribute\AttributeImpl;
use Xml\Type\Reference\{
    AttributeReferenceBuilderInterface,
    AttributeReferenceInterface
};

class AttributeReferenceBuilderImpl implements AttributeReferenceBuilderInterface, ModelBuildOperationInterface
{
    private $referenceSourceAttribute;
    protected $attributeReferenceImpl;
    private $referenceTargetElement;

    public function __construct(AttributeImpl $referenceSourceAttribute, string $referenceTargetElement)
    {
        $this->referenceSourceAttribute = $referenceSourceAttribute;
        $this->referenceTargetElement = $referenceTargetElement;
        $this->attributeReferenceImpl = new AttributeReferenceImpl($referenceSourceAttribute);
    }

    public function build(): AttributeReferenceInterface
    {
        $this->referenceSourceAttribute->registerOutgoingReference($this->attributeReferenceImpl);
        return $this->attributeReferenceImpl;
    }

    public function performModelBuild(ModelInterface $model): void
    {
        $referenceTargetType = $model->getType($this->referenceTargetElement);
        $this->attributeReferenceImpl->setReferenceTargetElementType($referenceTargetType);

        $idAttribute = $referenceTargetType->getAttribute("id");
        if ($idAttribute !== null) {
            $idAttribute->registerIncoming($this->attributeReferenceImpl);
            $this->attributeReferenceImpl->setReferenceTargetAttribute($idAttribute);
        } else {
            throw new ModelException(
                sprintf(
                    "Element type %s:%s has no id attribute",
                    $referenceTargetType->getTypeNamespace(),
                    $referenceTargetType->getTypeName()
                )
            );
        }
    }
}
