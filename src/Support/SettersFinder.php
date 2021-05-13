<?php

namespace D3jn\PhpDev\Support;

use ReflectionClass;
use ReflectionMethod;

class SettersFinder
{
    public function getSettersOf(string $class): array
    {
        $result = [];

        $class = new ReflectionClass($class);
        $methods = $class->getMethods(ReflectionMethod::IS_PUBLIC);
        foreach ($methods as $method) {
            if (! preg_match('/^set(?<name>.*)$/', $method->name, $matches)) {
                continue;
            }

            $result[] = strtolower($matches['name']);
        }
        sort($result);

        return $result;
    }
}
