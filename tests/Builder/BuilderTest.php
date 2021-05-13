<?php

namespace D3jn\PhpDev\Tests\Builder;

use D3jn\PhpDev\AbstractBuilder;
use D3jn\PhpDev\Exception\Builder\UnsupportedBuilderModifierException;
use D3jn\PhpDev\Tests\TestCase;

class BuilderTest extends TestCase
{
    public function testBuilderCanDetectItsModifiers()
    {
        $builder = new TestBuilder();

        $this->assertEquals(['name'], $builder->supportedModifiers());
    }

    public function testBuilderChangesResetStateAfterModifierIsSet()
    {
        $builder = new TestBuilder();

        $builder->setName('New name');

        $this->assertFalse($builder->isReset());
    }

    public function testBuilderDoesntAllowToSetUnsupportedModifier()
    {
        $this->expectException(UnsupportedBuilderModifierException::class);

        $builder = new TestBuilder();
        $builder->notAModifierSetter();
    }

    public function testBuilderHasInfoAboutSetAndNotSetModifiers()
    {
        $builder = new DerrivedTestBuilder();

        $builder->setName('New name');

        $this->assertTrue($builder->hasModifierSet('name'));
        $this->assertFalse($builder->hasModifierSet('surname'));
    }

    public function testBuilderIsInResetStateAfterBeingCreated()
    {
        $builder = new TestBuilder();

        $this->assertTrue($builder->isReset());
    }

    public function testBuilderProvidesCurrentModifierValue()
    {
        $builder = new TestBuilder();

        $builder->setName('New name');

        $this->assertEquals('New name', $builder->getName());
    }

    public function testBuilderProvidesDefaultValueForNotSetModifier()
    {
        $builder = new TestBuilder();

        $this->assertEquals('', $builder->getName());
    }

    public function testDerrivedBuilderCorrectlyDetectsItsModifiers()
    {
        $builder = new TestBuilder();
        $derrivedBuilder = new DerrivedTestBuilder();

        $this->assertEquals(['name'], $builder->supportedModifiers());
        $this->assertEquals(['name', 'surname'], $derrivedBuilder->supportedModifiers());
    }
}

class TestBuilder extends AbstractBuilder
{
    public function getName(): string
    {
        return $this->getModifier('name', '');
    }

    public function notAModifierSetter()
    {
        $this->setModifier('unsupported', 'value');
    }

    public function setName($value)
    {
        $this->setModifier('name', $value);
    }
}

class DerrivedTestBuilder extends TestBuilder
{
    public function setSurname($value)
    {
        $this->setModifier('surname', $value);
    }
}
