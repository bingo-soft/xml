<?php

namespace Xml\Impl\Type\Attribute;

use Xml\ModelInterface;
use Xml\Exception\ModelException;
use Xml\Impl\Type\ModelElementTypeImpl;
use Xml\Instance\ModelElementInstanceInterface;
use Xml\Type\Attribute\StringAttributeBuilderInterface;
use Xml\Type\Reference\{
    AttributeReferenceBuilderInterface,
    AttributeReferenceCollectionInterface,
    AttributeReferenceCollectionBuilderInterface
};
use Xml\Impl\Type\Reference\{
    AttributeReferenceBuilderImpl,
    AttributeReferenceCollectionBuilderImpl,
    QNameAttributeReferenceBuilderImpl
};

class StringAttributeBuilderImpl extends AttributeBuilderImpl implements StringAttributeBuilderInterface
{
    private $referenceBuilder;

    public function __construct(string $attributeName, ModelElementTypeImpl $modelType)
    {
        parent::__construct($attributeName, $modelType, new StringAttribute($modelType));
    }

    public function namespace(string $namespaceUri): StringAttributeBuilderInterface
    {
        return parent::namespace($namespaceUri);
    }

    /**
     * @param mixed $defaultValue
     */
    public function defaultValue($defaultValue): StringAttributeBuilderInterface
    {
        return parent::defaultValue($defaultValue);
    }

    public function required(): StringAttributeBuilderInterface
    {
        return parent::required();
    }

    public function idAttribute(): StringAttributeBuilderInterface
    {
        return parent::idAttribute();
    }

    public function qNameAttributeReference(string $referenceTargetElement): AttributeReferenceBuilderInterface
    {
        $attribute = $this->build();
        $referenceBuilder = new QNameAttributeReferenceBuilderImpl($attribute, $referenceTargetElement);
        $this->setAttributeReference($referenceBuilder);
        return $referenceBuilder;
    }

    public function idAttributeReference(string $referenceTargetElement): AttributeReferenceBuilderInterface
    {
        $attribute = $this->build();
        $referenceBuilder = new AttributeReferenceBuilderImpl($attribute, $referenceTargetElement);
        $this->setAttributeReference($referenceBuilder);
        return $referenceBuilder;
    }

    public function idAttributeReferenceCollection(
        string $referenceTargetElement,
        string $attributeReferenceCollection
    ): AttributeReferenceCollectionBuilderInterface {
        $attribute = $this->build();
        $referenceBuilder = new AttributeReferenceCollectionBuilderImpl(
            $attribute,
            $referenceTargetElement,
            $attributeReferenceCollection
        );
        $this->setAttributeReference($referenceBuilder);
        return $referenceBuilder;
    }

    protected function setAttributeReference(AttributeReferenceBuilderInterface $referenceBuilder): void
    {
        if ($this->referenceBuilder !== null) {
            throw new ModelException("An attribute cannot have more than one reference");
        }
        $this->referenceBuilder = $referenceBuilder;
    }

    public function performModelBuild(ModelInterface $model): void
    {
        parent::performModelBuild($model);
        if ($this->referenceBuilder !== null) {
            $this->referenceBuilder->performModelBuild($model);
        }
    }
}
