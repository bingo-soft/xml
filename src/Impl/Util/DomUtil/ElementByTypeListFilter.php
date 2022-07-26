<?php

namespace Xml\Impl\Util\DomUtil;

use Xml\Impl\ModelInstanceImpl;
use Xml\Impl\Instance\DomElementImpl;
use Xml\Impl\Util\ModelUtil;

class ElementByTypeListFilter extends ElementNodeListFilter
{
    private $type;
    private $model;

    /**
     * @param mixed $type
     */
    public function __construct($type, ModelInstanceImpl $modelInstance)
    {
        $this->type = $type;
        $this->model = $modelInstance;
    }

    /**
     * @param mixed $element
     */
    public function matches($element): bool
    {
        if (!parent::matches($element)) {
            return false;
        }
        $modelElement = ModelUtil::getModelElement(new DomElementImpl($element), $this->model);
        return $modelElement instanceof $this->type;
    }
}
