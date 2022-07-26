<?php

namespace Tests\TestModel\Instance;

use Xml\ModelBuilder;
use Xml\Impl\Instance\{
    ModelElementInstanceImpl,
    ModelTypeInstanceContext
};
use Xml\Type\ModelTypeInstanceProviderInterface;
use Tests\TestModel\TestModelConstants;

class Description extends ModelElementInstanceImpl
{
    public function __construct(ModelTypeInstanceContext $instanceContext)
    {
        parent::__construct($instanceContext);
    }

    public static function registerType(ModelBuilder $modelBuilder): void
    {
        $typeBuilder = $modelBuilder->defineType(
            Description::class,
            TestModelConstants::ELEMENT_NAME_DESCRIPTION
        )
        ->namespaceUri(TestModelConstants::MODEL_NAMESPACE)
        ->instanceProvider(
            new class implements ModelTypeInstanceProviderInterface
            {
                public function newInstance(ModelTypeInstanceContext $instanceContext): Description
                {
                    return new Description($instanceContext);
                }
            }
        );

        $typeBuilder->build();
    }
}
