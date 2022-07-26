<?php

namespace Xml\Impl\Type\Reference;

use Xml\Impl\Type\Attribute\AttributeImpl;
use Xml\Impl\Util\QName;
use Xml\Instance\ModelElementInstanceInterface;

class QNameAttributeReferenceImpl extends AttributeReferenceImpl
{
    public function __construct(AttributeImpl $referenceSourceAttribute)
    {
        parent::__construct($referenceSourceAttribute);
    }

    public function getReferenceIdentifier(ModelElementInstanceInterface $referenceSourceElement): ?string
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
