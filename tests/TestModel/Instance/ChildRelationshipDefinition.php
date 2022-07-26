<?php

namespace Tests\TestModel\Instance;

use Xml\ModelBuilder;
use Xml\Impl\Instance\{
    ModelElementInstanceImpl,
    ModelTypeInstanceContext
};
use Xml\Type\ModelTypeInstanceProviderInterface;
use Tests\TestModel\TestModelConstants;

class ChildRelationshipDefinition extends RelationshipDefinition
{
    public function __construct(ModelTypeInstanceContext $instanceContext)
    {
        parent::__construct($instanceContext);
    }

    public static function registerType(ModelBuilder $modelBuilder): void
    {
        $typeBuilder = $modelBuilder->defineType(
            ChildRelationshipDefinition::class,
            TestModelConstants::TYPE_NAME_CHILD_RELATIONSHIP_DEFINITION
        )
        ->namespaceUri(TestModelConstants::MODEL_NAMESPACE)
        ->extendsType(RelationshipDefinition::class)
        ->instanceProvider(
            new class implements ModelTypeInstanceProviderInterface
            {
                public function newInstance(ModelTypeInstanceContext $instanceContext): ChildRelationshipDefinition
                {
                    return new ChildRelationshipDefinition($instanceContext);
                }
            }
        );

        $typeBuilder->build();
    }
}
