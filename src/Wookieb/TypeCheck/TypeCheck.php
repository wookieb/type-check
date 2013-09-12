<?php

namespace Wookieb\TypeCheck;

/**
 * @author Łukasz Kużyński "wookieb" <lukasz.kuzynski@gmail.com>
 */
class TypeCheck
{
    private static $instances = array();

    private static function get($name)
    {
        if (!isset(self::$instances[$name])) {
            $createMethod = 'create'.$name;
            self::$instances[$name] = self::$createMethod();
        }
        return self::$instances[$name];
    }

    private static function createString()
    {
        return new SimpleTypeCheck('string');
    }

    private static function createInteger()
    {
        return new SimpleTypeCheck('integer');
    }

    private static function createBoolean()
    {
        return new SimpleTypeCheck('boolean');
    }

    private static function createFloat()
    {
        return new SimpleTypeCheck('float');
    }

    private static function createArray()
    {
        return new SimpleTypeCheck('array');
    }

    private static function createObject()
    {
        return new SimpleTypeCheck('object');
    }

    private static function createResource()
    {
        return new SimpleTypeCheck('resource');
    }

    /**
     * Returns type check that accepts only strings
     *
     * @return SimpleTypeCheck
     */
    public static function strings()
    {
        return self::get('String');
    }

    /**
     * Returns type check that accepts only integers
     *
     * @return SimpleTypeCheck
     */
    public static function integers()
    {
        return self::get('Integer');
    }

    /**
     * Returns type check that accepts only booleans
     *
     * @return SimpleTypeCheck
     */
    public static function booleans()
    {
        return self::get('Boolean');
    }

    /**
     * Returns type check that accepts only floats, doubles
     *
     * @return SimpleTypeCheck
     */
    public static function floats()
    {
        return self::get('Float');
    }

    /**
     * Returns type check that accepts only arrays
     *
     * @return SimpleTypeCheck
     */
    public static function arrays()
    {
        return self::get('Array');
    }

    /**
     * Returns type check that accepts only objects
     *
     * @return SimpleTypeCheck
     */
    public static function objects()
    {
        return self::get('Object');
    }

    /**
     * Returns type check that accepts only resources
     *
     * @return SimpleTypeCheck
     */
    public static function resources()
    {
        return self::get('Resource');
    }
} 
