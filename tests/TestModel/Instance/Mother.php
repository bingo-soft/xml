<?php

namespace Tests\TestModel\Instance;

use Xml\ModelBuilder;
use Xml\Impl\Instance\ModelTypeInstanceContext;
use Xml\Type\ModelTypeInstanceProviderInterface;
use Tests\TestModel\TestModelConstants;

class Mother extends AnimalReference
{
    public function __construct(ModelTypeInstanceContext $instanceContext)
    {
        parent::__construct($instanceContext);
    }

    public static function registerType(ModelBuilder $modelBuilder): void
    {
        $typeBuilder = $modelBuilder->defineType(
            Mother::class,
            TestModelConstants::ELEMENT_NAME_MOTHER
        )
        ->namespaceUri(TestModelConstants::MODEL_NAMESPACE)
        ->extendsType(AnimalReference::class)
        ->instanceProvider(
            new class implements ModelTypeInstanceProviderInterface
            {
                public function newInstance(ModelTypeInstanceContext $instanceContext): Mother
                {
                    return new Mother($instanceContext);
                }
            }
        );

        $typeBuilder->build();
    }
}
