<?php

namespace Tests\TestModel;

use PHPUnit\Framework\TestCase;
use Xml\ModelInstanceInterface;
use Xml\Impl\Parser\AbstractModelParser;
use Tests\TestModel\TestModelParser;
use Tests\TestModel\Instance\{
    Animal,
    Bird,
    RelationshipDefinition,
    Egg
};

abstract class TestModelTest extends TestCase
{
    protected $modelParser;

    protected $modelInstance;

    /**
     * @param string $test
     */
    protected function parseModel(string $test)
    {
        $this->modelParser = new TestModelParser();
        $xml = fopen('tests/TestModel/Resources/TestModel/' . $test . '.xml', 'r+');
        $this->modelInstance = $this->modelParser->parseModelFromStream($xml);
    }

    public function createBird(ModelInstanceInterface $modelInstance, string $id, string $gender): Bird
    {
        $bird = $modelInstance->newInstance(Bird::class, $id);
        $bird->setGender($gender);
        $animals = $modelInstance->getDocumentElement();
        $animals->addAnimal($bird);
        return $bird;
    }

    protected function createRelationshipDefinition(
        ModelInstanceInterface $modelInstance,
        Animal $animalInRelationshipWith,
        string $relationshipDefinitionClass
    ): RelationshipDefinition {
        $relationshipDefinition = $modelInstance->newInstance(
            $relationshipDefinitionClass,
            "relationship-" . $animalInRelationshipWith->getId()
        );
        $relationshipDefinition->setAnimal($animalInRelationshipWith);
        return $relationshipDefinition;
    }

    protected function addRelationshipDefinition(
        Animal $animalWithRelationship,
        RelationshipDefinition $relationshipDefinition
    ): void {
        $animalInRelationshipWith = $relationshipDefinition->getAnimal();
        $relationshipDefinition->setId($animalWithRelationship->getId() . "-" . $animalInRelationshipWith->getId());
        $animalWithRelationship->addRelationship($relationshipDefinition);
    }

    public function createEgg(ModelInstanceInterface $modelInstance, string $id): Egg
    {
        $egg = $modelInstance->newInstance(Egg::class, $id);
        return $egg;
    }
}
