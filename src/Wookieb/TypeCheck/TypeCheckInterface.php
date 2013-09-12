<?php
namespace Wookieb\TypeCheck;

/**
 * @author Łukasz Kużyński "wookieb" <lukasz.kuzynski@gmail.com>
 */
interface TypeCheckInterface
{
    /**
     * Checks whether given value is has valid type
     *
     * @param mixed $data
     * @return boolean
     */
    function isValidType($data);

    /**
     * Returns description of types
     *
     * @return string
     */
    function getTypeDescription();
} 
