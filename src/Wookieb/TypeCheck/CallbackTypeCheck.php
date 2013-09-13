<?php

namespace Wookieb\TypeCheck;

/**
 * Accepts data for which given callback returns true
 *
 * @author Łukasz Kużyński "wookieb" <lukasz.kuzynski@gmail.com>
 */
class CallbackTypeCheck implements TypeCheckInterface
{
    /**
     * @var callback
     */
    private $callback;
    private $description;

    public function __construct($callback, $description = null)
    {
        if (!is_callable($callback, true)) {
            throw new \InvalidArgumentException('Callback must be a callable');
        }

        $this->callback = $callback;
        $this->description = trim($description);
    }

    /**
     * {@inheritDoc}
     */
    public function isValidType($data)
    {
        return call_user_func($this->callback, $data);
    }

    /**
     * {@inheritDoc}
     */
    public function getTypeDescription()
    {
        return $this->description ? : 'no description of type';
    }
} 
