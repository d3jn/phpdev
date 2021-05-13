<?php

namespace D3jn\PhpDev\Exception\Builder;

use D3jn\PhpDev\AbstractBuilder;
use D3jn\PhpDev\Exception\PhpDevException;

class UnsupportedBuilderModifierException extends PhpDevException
{
    private $builder;
    private $name;

    public function __construct(AbstractBuilder $builder, string $name)
    {
        $this->builder = $builder;
        $this->name = $name;

        parent::__construct(sprintf(
            'Builder %s does not support modifier "%s"!',
            get_class($this->builder),
            $name
        ));
    }

    public function getBuilder(): AbstractBuilder
    {
        return $this->builder;
    }

    public function getModifierName(): string
    {
        return $this->name;
    }
}
