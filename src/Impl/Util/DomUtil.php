<?php

namespace Xml\Impl\Util;

use Xml\Impl\Instance\{
    DomDocumentExt,
    DomDocumentImpl
};
use Xml\Instance\DomDocumentInterface;
use Xml\Impl\ModelInstanceImpl;
use Xml\Impl\Instance\DomElementImpl;
use Xml\Impl\Util\DomUtil\{
    ElementNodeListFilter,
    NodeListFilterInterface,
    ElementByNameListFilter,
    ElementByTypeListFilter
};

class DomUtil
{
    public static function filterNodeList(\DOMNodeList $nodeList, NodeListFilterInterface $filter): array
    {
        $filteredList = [];
        foreach ($nodeList as $node) {
            if ($filter->matches($node)) {
                $filteredList[] = new DomElementImpl($node);
            }
        }
        return $filteredList;
    }

    public static function filterNodeListForElements(\DOMNodeList $nodeList): array
    {
        return self::filterNodeList($nodeList, new ElementNodeListFilter());
    }

    public static function filterNodeListByName(
        \DOMNodeList $nodeList,
        string $namespaceUri,
        string $localName
    ): array {
        return self::filterNodeList($nodeList, new ElementByNameListFilter($localName, $namespaceUri));
    }

    public static function filterNodeListByType(
        \DOMNodeList $nodeList,
        ModelInstanceImpl $modelInstance,
        string $type
    ): array {
        return self::filterNodeList($nodeList, new ElementByTypeListFilter($type, $modelInstance));
    }

    /**
     * @param resource $inputStream
     */
    public static function parseInputStream($inputStream): DomDocumentInterface
    {
        $dom = new DomDocumentExt();
        $meta = stream_get_meta_data($inputStream);
        if ($meta['wrapper_type'] == 'plainfile') {
            $dom->loadXML(fread($inputStream, filesize($meta['uri'])));
        } elseif ($meta['wrapper_type'] == 'http') {
            $dom->loadXML(stream_get_contents($inputStream));
        }
        return new DomDocumentImpl($dom);
    }

    public static function getEmptyDocument(): DomDocumentInterface
    {
        $dom = new DomDocumentExt();
        return new DomDocumentImpl($dom);
    }
}
