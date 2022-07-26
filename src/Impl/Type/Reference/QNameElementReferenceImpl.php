<?php

namespace Xml\Impl\Type\Reference;

use Xml\Impl\Util\QName;
use Xml\Type\Child\ChildElementInterface;
use Xml\Instance\ModelElementInstanceInterface;

class QNameElementReferenceImpl extends ElementReferenceImpl
{
    public function __construct(ChildElementInterface $referenceSourceCollection)
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
