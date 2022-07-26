<?php

namespace Xml\Impl\Type\Reference;

use Xml\Impl\Util\QName;
use Xml\Type\Child\ChildElementCollectionInterface;
use Xml\Instance\ModelElementInstanceInterface;

class QNameElementReferenceCollectionImpl extends ElementReferenceCollectionImpl
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
        $identifier = parent::getReferenceIdentifier($referenceSourceElement);
        if (!empty($identifier)) {
            $qName = QName::parseQName($identifier);
            return $qName->getLocalName();
        } else {
            return null;
        }
    }
}
