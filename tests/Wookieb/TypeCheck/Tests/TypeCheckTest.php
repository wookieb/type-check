<?php

namespace Wookieb\TypeCheck\Tests;

use Wookieb\TypeCheck\SimpleTypeCheck;
use Wookieb\TypeCheck\TypeCheck;

class TypeCheckTest extends \PHPUnit_Framework_TestCase
{
    public function dataProvider()
    {
        return array(
            'strings' => array('strings'),
            'integers' => array('integers'),
            'booleans' => array('booleans'),
            'objects' => array('objects'),
            'floats' => array('floats'),
            'arrays' => array('arrays'),
            'resources' => array('resources'),
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testShouldReturnsAlwaysSameInstance($staticMethodName)
    {
        $objectA = TypeCheck::$staticMethodName();
        $objectB = TypeCheck::$staticMethodName();

        $this->assertSame($objectA, $objectB);
    }
}
