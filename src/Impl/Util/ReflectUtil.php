<?php

namespace Xml\Impl\Util;

use Xml\Exception\ModelException;

abstract class ReflectUtil
{
    public static function getResourceAsStream(string $name): ?string
    {
        return file_exists($name) ? file_get_contents($name) : null;
    }

    /**
     * @param string $name
     * @param mixed $classLoader
     *
     * @return string|null
     */
    public static function getResource(string $name, $classLoader = null): ?string
    {
        if ($classLoader !== null && method_exists($classLoader, 'getResource')) {
            return $classLoader->getResource($name);
        }
        return file_exists($name) ? file_get_contents($name) : null;
    }

    /**
     * @return resource
     */
    public static function getResourceAsFile(string $path)
    {
        if (file_exists($path)) {
            return fopen($path, 'r+');
        } else {
             throw new ModelException(sprintf("Exception while loading resource file %s", $path));
        }
    }

    /**
     * @param mixed $parameters
     *
     * @return mixed
     */
    public static function createInstance(string $type, ...$parameters)
    {
        try {
            return new $type(...$parameters);
        } catch (\Exception $e) {
            throw new ModelException(sprintf("Exception while creating an instance of type %s", $type));
        }
    }
}
