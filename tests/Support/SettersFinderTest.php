<?php

namespace D3jn\PhpDev\Tests\Support;

use D3jn\PhpDev\Support\SettersFinder;
use D3jn\PhpDev\Tests\TestCase;

class SettersFinderTest extends TestCase
{
    public function testFinderGetsOnlyPublicSetterMethods()
    {
        $finder = new SettersFinder();

        $setters = $finder->getSettersOf(TestClass::class);

        $this->assertEquals(['name'], $setters);
    }
}

class TestClass
{
    public function setName($name)
    {
        return;
    }

    protected function setSurname($surname)
    {
        return;
    }
}
