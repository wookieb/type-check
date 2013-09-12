<?php

namespace Wookieb\TypeCheck;

/**
 * Accepts every data that are accepted by at least one provided type check
 *
 * @author Łukasz Kużyński "wookieb" <lukasz.kuzynski@gmail.com>
 */
class MultipleTypesCheck implements TypeCheckInterface
{
    private $types = array();

    /**
     * @param array|TypeCheckInterface $checks,...
     * @throws \InvalidArgumentException when one of provided type check is not an object of TypeCheckInterface
     * @throws \BadMethodCallException when less than 2 type checks provided
     */
    public function __construct($checks)
    {
        if (!is_array($checks)) {
            $checks = func_get_args();
        }
        foreach ($checks as $check) {
            if (!$check instanceof TypeCheckInterface) {
                throw new \InvalidArgumentException('Provided type check it is not an instance of TypeCheckInterface');
            }
            $this->types[] = $check;
        }
        if (count($this->types) < 2) {
            throw new \BadMethodCallException('At least 2 type checks required');
        }
    }

    /**
     * {@inheritDoc}
     */
    public function isValidType($data)
    {
        foreach ($this->types as $type) {
            /* @var TypeCheckInterface $type */
            if ($type->isValidType($data)) {
                return true;
            }
        }
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function getTypeDescription()
    {
        $descriptions = array();
        foreach ($this->types as $type) {
            /* @var TypeCheckInterface $type */
            $descriptions[] = $type->getTypeDescription();
        }
        return implode(', ', $descriptions);
    }
} 
