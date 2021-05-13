<?php

namespace D3jn\PhpDev;

use D3jn\PhpDev\Exception\Builder\UnsupportedBuilderModifierException;
use D3jn\PhpDev\Support\SettersFinder;
use D3jn\PhpDev\Traits\HasState;

abstract class AbstractBuilder
{
    use HasState;

    private $isReset;
    private $modifiers;

    public function __construct()
    {
        $this->reset();
    }

    public function hasModifierSet(string $name): bool
    {
        return array_key_exists($name, $this->modifiers);
    }

    public function isReset(): bool
    {
        return $this->isReset;
    }

    public function reset()
    {
        $this->resetState();

        $this->modifiers = [];

        $this->isReset = true;
    }

    public function supportedModifiers(): array
    {
        static $supportedModifiers = null;

        if (null !== $supportedModifiers) {
            return $supportedModifiers;
        }

        $supportedModifiers = (new SettersFinder())->getSettersOf(static::class);

        return $supportedModifiers;
    }

    /**
     * @throws \D3jn\PhpDev\Exception\Builder\UnsupportedBuilderModifierException
     */
    protected function assertModifierIsSupported(string $name): void
    {
        if (! in_array($name, $this->supportedModifiers())) {
            throw new UnsupportedBuilderModifierException($this, $name);
        }
    }

    protected function getModifier(string $name, $default = null)
    {
        $this->assertModifierIsSupported($name);

        return $this->hasModifierSet($name) ? $this->modifiers[$name] : $default;
    }

    protected function setModifier(string $name, $value): void
    {
        $this->assertModifierIsSupported($name);

        $this->modifiers[$name] = $value;
        $this->isReset = false;
    }

    protected function unsetModifier(string $name): void
    {
        if ($this->hasModifierSet($name)) {
            unset($this->modifiers[$name]);
        }
    }
}
