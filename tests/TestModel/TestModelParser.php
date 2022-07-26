<?php

namespace Tests\TestModel;

use Xml\ModelInstanceInterface;
use Xml\Impl\ModelInstanceImpl;
use Xml\Impl\Parser\AbstractModelParser;
use Xml\Instance\DomDocumentInterface;

class TestModelParser extends AbstractModelParser
{
    private const SCHEMA_LOCATION = "tests/TestModel/Resources/TestModel/Testmodel.xsd";
    private const TEST_NS = "http://test.org/animals";

    public function __construct()
    {
        $this->addSchema(self::TEST_NS, self::SCHEMA_LOCATION);
    }

    protected function createModelInstance(DomDocumentInterface $document): ModelInstanceInterface
    {
        return new ModelInstanceImpl(TestModel::getTestModel(), TestModel::getModelBuilder(), $document);
    }
}
