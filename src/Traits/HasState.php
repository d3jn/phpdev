<?php

namespace D3jn\PhpDev\Traits;

trait HasState
{
    private $state = [];

    protected function getState(string $name)
    {
        if (! $this->hasState($name)) {
            return null;
        }

        return $this->state[$name];
    }

    protected function hasState(string $name): bool
    {
        return array_key_exists($name, $this->state);
    }

    protected function resetState(): void
    {
        $this->state = [];
    }

    protected function setState(string $name, $value): void
    {
        $this->state[$name] = $value;
    }
}
