<?php
namespace Wookieb\TypeCheck\Tests;

use Wookieb\TypeCheck\SimpleTypeCheck;

class SimpleTypeCheckTest extends \PHPUnit_Framework_TestCase
{
    public function complexTestDataProvider()
    {
        return array(
            'strings' => array('string', 'test', false, 'strings'),
            'booleans' => array('boolean', true, 'string', 'booleans'),
            'bool' => array('bool', true, 'string', 'booleans'),
            'integers' => array('integer', 123, 'string', 'integers'),
            'floats' => array('float', 123.3, 'string', 'doubles'),
            'doubles' => array('double', 123.3, 'string', 'doubles'),
            'nulls' => array('null', null, false, 'nulls'),
            'resources' => array('resource', fopen(__FILE__, 'r'), __FILE__, 'resources'),
            'objects' => array('object', new \stdClass(), 'str', 'objects')
        );
    }

    /**
     * @dataProvider complexTestDataProvider
     */
    public function testComplexTest($typeName, $validData, $invalidData, $description)
    {
        $typeCheck = new SimpleTypeCheck($typeName);
        $this->assertTrue($typeCheck->isValidType($validData));
        $this->assertFalse($typeCheck->isValidType($invalidData));
        $this->assertEquals($description, $typeCheck->getTypeDescription());
    }

    public function testExceptionWhenTypeIsNotSupported()
    {
        $this->setExpectedException('\InvalidArgumentException', 'Unsupported type "Duck"');
        new SimpleTypeCheck('Duck');
    }

    /**
     * @depends testComplexTest
     */
    public function testAllowsToAliasTypes()
    {
        SimpleTypeCheck::registerTypeAlias('Bb', 'boolean');
        $typeCheck = new SimpleTypeCheck('Bb');
        $this->assertTrue($typeCheck->isValidType(false));
    }
}
