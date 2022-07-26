<?php

namespace Xml\Impl\Util;

use Xml\Instance\{
    DomDocumentInterface,
    DomElementInterface
};

class XmlQName
{
    public const KNOWN_PREFIXES = [
        'http://www.test.com/fox' => 'fox',
        'http://activiti.org/bpmn' => 'test',
        'http://test.org/schema/1.0/bpmn' => 'test',
        'http://www.omg.org/spec/BPMN/20100524/MODEL' => 'bpmn2',
        'http://www.omg.org/spec/BPMN/20100524/DI' => 'di',
        'http://www.omg.org/spec/DD/20100524/DI' => 'di',
        'http://www.omg.org/spec/DD/20100524/DC' => 'dc',
        'http://www.w3.org/2000/xmlns/' => ''
    ];

    protected $rootElement;
    protected $element;
    protected $localName;
    protected $namespaceUri;
    protected $prefix;

    public function __construct(
        ?DomDocumentInterface $document,
        ?DomElementInterface $element,
        ?string $namespaceUri,
        string $localName
    ) {
        if ($element !== null) {
            $document = $element->getDocument();
            $this->rootElement = $document->getRootElement();
        } elseif ($document !== null) {
            $this->rootElement = $document->getRootElement();
        }
        $this->element = $element;
        $this->localName = $localName;
        $this->namespaceUri = $namespaceUri;
        $this->prefix = null;
    }

    public function getNamespaceUri(): ?string
    {
        return $this->namespaceUri;
    }

    public function getLocalName(): string
    {
        return $this->localName;
    }

    public function getPrefixedName(): string
    {
        if ($this->prefix === null) {
            $this->prefix = $this->determinePrefixAndNamespaceUri();
        }
        return QName::combine($this->prefix, $this->localName);
    }

    public function hasLocalNamespace(): bool
    {
        if ($this->element !== null) {
            return $this->element->getNamespaceURI() == $this->namespaceUri || empty($this->namespaceUri);
        }
        return false;
    }

    private function determinePrefixAndNamespaceUri(): ?string
    {
        if ($this->namespaceUri !== null) {
            if ($this->rootElement !== null && $this->namespaceUri == $this->rootElement->getNamespaceURI()) {
                return null;
            } else {
                $lookupPrefix = $this->lookupPrefix();
                if ($lookupPrefix === null && $this->rootElement !== null) {
                    $knownPrefix = array_search($this->namespaceUri, self::KNOWN_PREFIXES);
                    if ($knownPrefix === false) {
                        return $this->rootElement->registerNamespace(null, $this->namespaceUri);
                    } elseif (empty($knownPrefix)) {
                        return null;
                    } else {
                        $this->rootElement->registerNamespace($knownPrefix, $this->namespaceUri);
                        return $knownPrefix;
                    }
                } else {
                    return $lookupPrefix;
                }
            }
        } else {
            return null;
        }
    }

    private function lookupPrefix(): ?string
    {
        if ($this->namespaceUri !== null) {
            $lookupPrefix = null;
            if ($this->element !== null) {
                $lookupPrefix = $this->element->lookupPrefix($this->namespaceUri);
            } elseif ($this->rootElement !== null) {
                $lookupPrefix = $this->rootElement->lookupPrefix($this->namespaceUri);
            }
            return $lookupPrefix;
        } else {
            return null;
        }
    }
}
