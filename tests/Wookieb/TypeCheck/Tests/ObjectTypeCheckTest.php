<?php

namespace Wookieb\TypeCheck\Tests;

use Wookieb\TypeCheck\ObjectTypeCheck;
use Wookieb\TypeCheck\SimpleTypeCheck;

class ObjectTypeCheckTest extends \PHPUnit_Framework_TestCase
{
    public function complexTestProvider()
    {
        return array(
            'not an object' => array('\Exception', false, array(), false),
            'instanceof invalid data' => array('\Exception', false, new \stdClass(), false),
            'instanceof' => array('\Exception', false, new \InvalidArgumentException('exc'), true),
            'exact match invalid' => array('\Exception', true, new \InvalidArgumentException('exc'), false),
            'exact match' => array('\Exception', true, new \Exception('exc'), true)
        );
    }

    /**
     * @dataProvider complexTestProvider
     */
    public function testComplexTest($class, $exactMatch, $value, $result)
    {
        $typeCheck = new ObjectTypeCheck($class, $exactMatch);
        $this->assertEquals($result, $typeCheck->isValidType($value));
    }

    public function getTypeDescriptionProvider()
    {
        return array(
            'exact match' => array('\Exception', false, 'instances of Exception'),
            'instanceof' => array('\Exception', true, 'objects of class Exception')
        );
    }

    /**
     * @dataProvider getTypeDescriptionProvider
     */
    public function testGetTypeDescription($class, $exactMatch, $expectedDescription)
    {
        $typeCheck = new ObjectTypeCheck($class, $exactMatch);
        $this->assertSame($expectedDescription, $typeCheck->getTypeDescription());
    }
}
