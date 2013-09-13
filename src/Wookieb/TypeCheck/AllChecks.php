<?php

namespace Wookieb\TypeCheck;

/**
 * Accepts only that data which pass every provided type check
 *
 * @author Łukasz Kużyński "wookieb" <lukasz.kuzynski@gmail.com>
 */
class AllChecks implements TypeCheckInterface
{
    private $typeChecks = array();

    /**
     * @param array|TypeCheckInterface $typeChecks,...
     * @throws \InvalidArgumentException when one of provided argument is not an object of TypeCheckInterface
     * @throws \BadMethodCallException when insufficient amount of type checks provided
     */
    public function __construct($typeChecks)
    {
        if (!is_array($typeChecks)) {
            $typeChecks = func_get_args();
        }

        foreach ($typeChecks as $check) {
            if (!$check instanceof TypeCheckInterface) {
                throw new \InvalidArgumentException('Every type check must be an instance of TypeCheckInterface');
            }
            $this->typeChecks[] = $check;
        }
        if (count($this->typeChecks) < 2) {
            throw new \BadMethodCallException('At least 2 type checks required');
        }
    }

    /**
     * {@inheritDoc}
     */
    public function isValidType($data)
    {
        foreach ($this->typeChecks as $check) {
            /* @var TypeCheckInterface $check */
            if (!$check->isValidType($data)) {
                return false;
            }
        }
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function getTypeDescription()
    {
        return implode(' ', array_map(function (TypeCheckInterface $check) {
            return $check->getTypeDescription();
        }, $this->typeChecks));
    }
} 
