<?php

namespace Xml\Impl\Type\Reference;

use Xml\Exception\{
    ModelException,
    ModelReferenceException,
    UnsupportedModelOperationException
};
use Xml\Impl\Instance\ModelElementInstanceImpl;
use Xml\Impl\Type\ModelElementTypeImpl;
use Xml\Impl\Util\ModelUtil;
use Xml\Instance\ModelElementInstanceInterface;
use Xml\Type\ModelElementTypeInterface;
use Xml\Type\Child\ChildElementCollectionInterface;
use Xml\Type\Reference\ElementReferenceCollectionInterface;

class ElementReferenceCollectionImpl extends ReferenceImpl implements ElementReferenceCollectionInterface
{
    private $referenceSourceCollection;
    private $referenceSourceType;

    public function __construct(ChildElementCollectionInterface $referenceSourceCollection)
    {
        $this->referenceSourceCollection = $referenceSourceCollection;
    }

    public function getReferenceSourceCollection(): ChildElementCollectionInterface
    {
        return $this->referenceSourceCollection;
    }

    protected function setReferenceIdentifier(
        ModelElementInstanceInterface $referenceSourceElement,
        string $referenceIdentifier
    ): void {
        $referenceSourceElement->setTextContent($referenceIdentifier);
    }

    protected function performAddOperation(
        ModelElementInstanceImpl $referenceSourceParentElement,
        ModelElementInstanceInterface $referenceTargetElement
    ): void {
        $modelInstance = $referenceSourceParentElement->getModelInstance();
        $referenceTargetIdentifier = $this->referenceTargetAttribute->getValue($referenceTargetElement);
        $existingElement = $modelInstance->getModelElementById($referenceTargetIdentifier);
        if ($existingElement === null || !$referenceTargetElement->equals($existingElement)) {
            throw new ModelReferenceException("Cannot create reference to model element");
        } else {
            $referenceSourceElement = $modelInstance->newInstance($this->referenceSourceType);
            $this->referenceSourceCollection->add($referenceSourceParentElement, $referenceSourceElement);
            $this->setReferenceIdentifier($referenceSourceElement, $referenceTargetIdentifier);
        }
    }

    protected function performRemoveOperation(
        ModelElementInstanceImpl $referenceSourceParentElement,
        ModelElementInstanceInterface $referenceTargetElement
    ): void {
        $referenceSourceChildElements = $referenceSourceParentElement->getChildElementsByType(
            $this->referenceSourceType
        );
        foreach ($referenceSourceChildElements as $referenceSourceChildElement) {
            if ($referenceTargetElement->equals($this->getReferenceTargetElement($referenceSourceChildElement))) {
                $referenceSourceParentElement->removeChildElement($referenceSourceChildElement);
            }
        }
    }

    protected function performClearOperation(
        ModelElementInstanceImpl $referenceSourceParentElement,
        array $elementsToRemove
    ): void {
        foreach ($elementsToRemove as $element) {
            $referenceSourceParentElement->getDomElement()->removeChild($element);
        }
    }

    /**
     * @return mixed
     */
    public function getReferenceIdentifier(ModelElementInstanceInterface $referenceSourceElement)
    {
        return $referenceSourceElement->getTextContent();
    }

    protected function updateReference(
        ModelElementInstanceInterface $referenceSourceElement,
        ?string $oldIdentifier,
        string $newIdentifier
    ): void {
        $referencingTextContent = $this->getReferenceIdentifier($referenceSourceElement);
        if ($oldIdentifier !== null && $oldIdentifier == $referencingTextContent) {
            $this->setReferenceIdentifier($referenceSourceElement, $newIdentifier);
        }
    }

    //@attention. $referenceTargetElement is mentioned, but not used
    protected function removeReference(
        ModelElementInstanceInterface $referenceSourceElement,
        ModelElementInstanceInterface $referenceTargetElement
    ): void {
        $parentElement = $referenceSourceElement->getParentElement();
        $this->referenceSourceCollection->remove($parentElement, $referenceSourceElement);
    }

    public function setReferenceSourceElementType(ModelElementTypeImpl $referenceSourceType): void
    {
        $this->referenceSourceType = $referenceSourceType;
    }

    public function getReferenceSourceElementType(): ModelElementTypeInterface
    {
        return $this->referenceSourceType;
    }

    protected function getView(ModelElementInstanceImpl $referenceSourceParentElement): array
    {
        $document = $referenceSourceParentElement->getModelInstance()->getDocument();
        $referenceSourceElements = $this->referenceSourceCollection->get($referenceSourceParentElement);
        $referenceTargetElements = [];
        foreach ($referenceSourceElements as $referenceSourceElement) {
            $identifier = $this->getReferenceIdentifier($referenceSourceElement);
            $referenceTargetElement = $document->getElementById($identifier);
            if ($referenceTargetElement !== null) {
                $referenceTargetElements[] = $referenceTargetElement;
            } else {
                throw new ModelException(spintf("Unable to find a model element instance for id %s", $identifier));
            }
        }
        return $referenceTargetElements;
    }

    public function size(ModelElementInstanceImpl $referenceSourceParentElement): int
    {
        return count($this->getView($referenceSourceParentElement));
    }

    public function isEmpty(ModelElementInstanceImpl $referenceSourceParentElement): bool
    {
        return count($this->getView($referenceSourceParentElement)) == 0;
    }

    public function contains(
        ModelElementInstanceImpl $referenceSourceParentElement,
        ?ModelElementInstanceInterface $elementToAdd
    ): bool {
        if ($elementToAdd === null) {
            return false;
        } else {
            foreach ($this->getView($referenceSourceParentElement) as $el) {
                if ($elementToAdd->getDomElement()->equals($el)) {
                    return true;
                }
            }
            return false;
        }
    }

    public function containsAll(
        ModelElementInstanceImpl $referenceSourceParentElement,
        array $c
    ): bool {
        $modelElementCollection = ModelUtil::getModelElementCollection(
            $this->getView($referenceSourceParentElement),
            $referenceSourceParentElement->getModelInstance()
        );
        foreach ($modelElementCollection as $el) {
            $flag = false;
            foreach ($c as $elementToCheck) {
                if ($elementToCheck->equals($el)) {
                    $flag = true;
                    break;
                }
            }
            if (!$flag) {
                return false;
            }
        }
        return true;
    }

    public function add(ModelElementInstanceImpl $referenceSourceParentElement, ModelElementInstanceInterface $e): bool
    {
        if ($this->referenceSourceCollection->isImmutable()) {
            throw new UnsupportedModelOperationException("collection is immutable");
        } else {
            if (!$this->contains($referenceSourceParentElement, $e)) {
                $this->performAddOperation($referenceSourceParentElement, $e);
            }
            return true;
        }
    }

    public function remove(
        ModelElementInstanceImpl $referenceSourceParentElement,
        ModelElementInstanceInterface $e
    ): bool {
        if ($this->referenceSourceCollection->isImmutable()) {
            throw new UnsupportedModelOperationException("collection is immutable");
        }
        $this->performRemoveOperation($referenceSourceParentElement, $e);
        return true;
    }

    public function addAll(ModelElementInstanceImpl $referenceSourceParentElement, array $c): bool
    {
        if ($this->referenceSourceCollection->isImmutable()) {
            throw new UnsupportedModelOperationException("collection is immutable");
        }
        $result = false;
        foreach ($c as $elementToAdd) {
            $result |= $this->add($referenceSourceParentElement, $elementToAdd);
        }
        return $result;
    }

    public function removeAll(ModelElementInstanceImpl $referenceSourceParentElement, array $c): bool
    {
        if ($this->referenceSourceCollection->isImmutable()) {
            throw new UnsupportedModelOperationException("collection is immutable");
        }
        $result = false;
        foreach ($c as $elementToRemove) {
            $result |= $this->remove($referenceSourceParentElement, $elementToRemove);
        }
        return $result;
    }

    public function retainAll(ModelElementInstanceImpl $referenceSourceParentElement, array $c): bool
    {
        throw new UnsupportedModelOperationException("retainAll not implemented");
    }

    public function clear(ModelElementInstanceImpl $referenceSourceParentElement): void
    {
        if ($this->referenceSourceCollection->isImmutable()) {
            throw new UnsupportedModelOperationException("collection is immutable");
        }
        $view = [];
        $referenceSourceElements = $this->referenceSourceCollection->get($referenceSourceParentElement);
        foreach ($referenceSourceElements as $referenceSourceElement) {
            $view[] = $referenceSourceElement->getDomElement();
        }
        $this->performClearOperation($referenceSourceParentElement, $view);
    }

    public function getReferenceTargetElements(ModelElementInstanceImpl $referenceSourceParentElement): array
    {
        return ModelUtil::getModelElementCollection(
            $this->getView($referenceSourceParentElement),
            $referenceSourceParentElement->getModelInstance()
        );
    }
}
