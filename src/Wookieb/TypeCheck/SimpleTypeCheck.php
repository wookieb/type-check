<?php

namespace Wookieb\TypeCheck;
use Wookieb\Assert\Assert;

/**
 * Simple type check achieved by gettype function
 * Handles the following types:
 * - boolean, bool
 * - integer, int
 * - double, float
 * - string
 * - null
 * - object
 * - resource
 *
 * @author Łukasz Kużyński "wookieb" <lukasz.kuzynski@gmail.com>
 */
class SimpleTypeCheck implements TypeCheckInterface
{
    private static $allowedTypes = array(
        'boolean',
        'integer',
        'double',
        'string',
        'array',
        'object',
        'resource',
        'NULL'
    );

    private static $aliases = array(
        'bool' => 'boolean',
        'int' => 'integer',
        'float' => 'double',
        'null' => 'NULL'
    );

    private $type;

    /**
     * @param string $type type name supported by gettype or aliased type name
     * @throws \InvalidArgumentException when type is not supported
     */
    public function __construct($type)
    {
        $typeName = strtolower($type);
        if (isset(self::$aliases[$typeName])) {
            $typeName = self::$aliases[$typeName];
        }
        if (!in_array($typeName, self::$allowedTypes)) {
            throw new \InvalidArgumentException('Unsupported type "'.$type.'"');
        }
        $this->type = $typeName;
    }

    /**
     * Registers alias for a type
     *
     * @param string $alias
     * @param string $type
     * @throws \InvalidArgumentException when alias or type is blank
     */
    public static function registerTypeAlias($alias, $type)
    {
        Assert::notBlank($alias, 'Alias name cannot be blank');
        Assert::notBlank($type, 'Target type name cannot be blank');
        self::$aliases[strtolower($alias)] = $type;
    }

    /**
     * {@inheritDoc}
     */
    public function isValidType($data)
    {
        return gettype($data) === $this->type;
    }

    /**
     * {@inheritDoc}
     */
    public function getTypeDescription()
    {
        return strtolower($this->type).'s';
    }
} 
