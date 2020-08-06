<?php

abstract class Enum
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param $name
     * @param $arguments
     * @return static
     * @throws InvalidEnumException
     */
    public static function __callStatic($name, $arguments)
    {
        $constants = static::getConstants();
        if (!isset($constants[$name])) {
            throw new InvalidEnumException("Constante indefinida");
        }
        return new static($constants[$name]);
    }

    protected static function getConstants()
    {
        $reflection = new ReflectionClass(static::class);
        return $reflection->getConstants();
    }
}
