<?php

namespace Tests\Xml\TestModel\Instance;

use Xml\ModelBuilder;
use Xml\Impl\Instance\{
    ModelElementInstanceImpl,
    ModelTypeInstanceContext
};
use Xml\Type\ModelTypeInstanceProviderInterface;
use Tests\Xml\TestModel\TestModelConstants;

class Wings extends ModelElementInstanceImpl
{
    public function __construct(ModelTypeInstanceContext $instanceContext)
    {
        parent::__construct($instanceContext);
    }

    public static function registerType(ModelBuilder $modelBuilder): void
    {
        $typeBuilder = $modelBuilder->defineType(
            Wings::class,
            TestModelConstants::TYPE_NAME_WINGS
        )
        ->namespaceUri(TestModelConstants::NEWER_NAMESPACE)
        ->instanceProvider(
            new class implements ModelTypeInstanceProviderInterface
            {
                public function newInstance(ModelTypeInstanceContext $instanceContext): Wings
                {
                    return new Wings($instanceContext);
                }
            }
        );

        $typeBuilder->build();
    }
}
