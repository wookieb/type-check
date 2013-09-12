<?php


namespace Wookieb\TypeCheck\Tests;


use Wookieb\TypeCheck\MultipleTypesCheck;
use Wookieb\TypeCheck\SimpleTypeCheck;

class MultipleTypesCheckTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var MultipleTypesCheck
     */
    protected $object;

    protected function setUp()
    {
        $this->object = new MultipleTypesCheck(array(
            new SimpleTypeCheck('string'),
            new SimpleTypeCheck('int'),
            new SimpleTypeCheck('array')
        ));
    }

    public function testListOfTypeChecksAsArgumentsOfConstructor()
    {
        $this->object = new MultipleTypesCheck(new SimpleTypeCheck('string'), new SimpleTypeCheck('int'));
        $this->assertTrue($this->object->isValidType('string'));
        $this->assertTrue($this->object->isValidType(123));
        $this->assertFalse($this->object->isValidType(range(1, 3)));
    }

    public function testInvalidType()
    {
        $this->assertFalse($this->object->isValidType(2.3));
        $this->assertFalse($this->object->isValidType(new \stdClass()));
    }

    public function testValidType()
    {
        $this->assertTrue($this->object->isValidType('string'));
        $this->assertTrue($this->object->isValidType(1));
        $this->assertTrue($this->object->isValidType(array(12, 123)));
    }

    public function testGetTypeDescription()
    {
        $this->assertSame('strings, integers, arrays', $this->object->getTypeDescription());
    }

    public function testExceptionWhenNoTypeChecksDefined()
    {
        $this->setExpectedException('BadMethodCallException', 'At least 2 type checks required');
        new MultipleTypesCheck(array());
    }

    public function testExceptionWhenInsufficientAmountOfTypeChecksDefined()
    {
        $this->setExpectedException('BadMethodCallException', 'At least 2 type checks required');
        new MultipleTypesCheck(new SimpleTypeCheck('string'));
    }

    public function testExceptionWhenProvidedTypeCheckIsNotReallyATypeCheck()
    {
        $this->setExpectedException('\InvalidArgumentException', 'Provided type check it is not an instance of TypeCheckInterface');
        new MultipleTypesCheck(array(
            new SimpleTypeCheck('string'),
            false
        ));
    }
}
