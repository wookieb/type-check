<?php

namespace Wookieb\TypeCheck;
use Wookieb\Assert\Assert;

/**
 * Handle checking the type of objects
 * May work in 2 modes:
 * - instanceof (default) - accepts objects that are instance of $className
 * - exact match - accepts objects where their class is the same as $className
 *
 * @author Łukasz Kużyński "wookieb" <lukasz.kuzynski@gmail.com>
 */
class ObjectTypeCheck implements TypeCheckInterface
{
    private $className;

    /**
     * @param string $className
     * @param bool $exactMatch comparison should be performed by exact class name match (true) or instanceof operator (false)
     */
    public function __construct($className, $exactMatch = false)
    {
        Assert::notBlank($className, 'Class name cannot be blank');
        $this->className = ltrim($className, '\\');
        $this->exactMatch = (bool)$exactMatch;
    }

    /**
     * {@inheritDoc}
     */
    public function isValidType($data)
    {
        return is_object($data) && ($this->exactMatch ?
            get_class($data) === $this->className : $data instanceof $this->className
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getTypeDescription()
    {
        if ($this->exactMatch) {
            return 'objects of class '.$this->className;
        }
        return 'instances of '.$this->className;
    }
} 
