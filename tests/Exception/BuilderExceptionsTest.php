<?php

namespace D3jn\PhpDev\Tests\Exception;

use D3jn\PhpDev\AbstractBuilder;
use D3jn\PhpDev\Exception\Builder\UnsupportedBuilderModifierException;
use D3jn\PhpDev\Tests\TestCase;

class BuilderExceptionsTest extends TestCase
{
    public function testUnsupportedBuilderModifierExceptionGetters()
    {
        $builder = $this->createMock(AbstractBuilder::class);
        $e = new UnsupportedBuilderModifierException($builder, 'name');

        $this->assertSame($builder, $e->getBuilder());
        $this->assertEquals('name', $e->getModifierName());
    }
}
