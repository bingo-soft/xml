<?php

namespace Xml\Impl\Type\Reference;

use Xml\Type\Child\ChildElementCollectionInterface;
use Xml\Instance\ModelElementInstanceInterface;

class UriElementReferenceCollectionImpl extends ElementReferenceCollectionImpl
{
    public function __construct(ChildElementCollectionInterface $referenceSourceCollection)
    {
        parent::__construct($referenceSourceCollection);
    }

    /**
     * @return mixed
     */
    public function getReferenceIdentifier(ModelElementInstanceInterface $referenceSourceElement)
    {
        $identifier = $referenceSourceElement->getAttributeValue("href");
        if ($identifier !== null) {
            $parts = explode('#', $identifier);
            if (count($parts) > 1) {
                return $parts[count($parts) - 1];
            } else {
                return $parts[0];
            }
        } else {
            return null;
        }
    }

    protected function setReferenceIdentifier(
        ModelElementInstanceInterface $referenceSourceElement,
        string $referenceIdentifier
    ): void {
        $referenceSourceElement->setAttributeValue("href", "#" . $referenceIdentifier);
    }
}
