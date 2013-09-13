<?php

namespace Wookieb\TypeCheck;

/**
 * Accepts traversable data structures (arrays, objects implementing \Traversable interface)
 * that contains values matching to given type check
 *
 * @author Łukasz Kużyński "wookieb" <lukasz.kuzynski@gmail.com>
 */
class TraversableOf implements TypeCheckInterface
{
    /**
     * @var TypeCheckInterface
     */
    private $type;

    public function __construct(TypeCheckInterface $type)
    {
        $this->type = $type;
    }

    /**
     * {@inheritDoc}
     */
    public function isValidType($data)
    {
        if (!is_array($data) && !$data instanceof \Traversable) {
            return false;
        }
        foreach ($data as $value) {
            if (!$this->type->isValidType($value)) {
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
        return 'traversable structures that contains '.$this->type->getTypeDescription();
    }
}
