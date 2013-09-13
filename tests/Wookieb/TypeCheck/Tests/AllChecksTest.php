<?php

namespace Wookieb\TypeCheck\Tests;

use Wookieb\TypeCheck\AllChecks;
use Wookieb\TypeCheck\SimpleTypeCheck;
use Wookieb\TypeCheck\TypeCheck;

class AllChecksTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AllChecks
     */
    private $object;

    protected function setUp()
    {
        $mock = $this->getMockForAbstractClass('Wookieb\TypeCheck\TypeCheckInterface');
        $mock->expects($this->any())
            ->method('isValidType')
            ->will($this->returnCallback(function ($value) {
                return reset($value) === 'foo';
            }));

        $mock->expects($this->any())
            ->method('getTypeDescription')
            ->will($this->returnValue('of foo strings'));
        $this->object = new AllChecks(array(
            new SimpleTypeCheck('array'),
            $mock
        ));
    }

    public function testIsValidType()
    {
        $this->assertFalse($this->object->isValidType('foo'));
        $this->assertFalse($this->object->isValidType(range(1, 4)));
        $this->assertTrue($this->object->isValidType(array('foo')));
    }

    public function testGetTypeDescription()
    {
        $this->assertSame('arrays of foo strings', $this->object->getTypeDescription());;
    }

    public function testRequiresAtLeast2TypeChecks()
    {
        $this->setExpectedException('\BadMethodCallException', 'At least 2 type checks required');
        new AllChecks(array(TypeCheck::strings()));
    }

    public function testExceptionWhenOneArgumentItIsNotTypeCheckInterfaceObject()
    {
        $this->setExpectedException('\InvalidArgumentException', 'Every type check must be an instance of TypeCheckInterface');
        new AllChecks(array(TypeCheck::strings(), false));
    }

    public function testShouldGetTypeChecksFromAllTheArgumentsOfConstructor()
    {
        $this->object = new AllChecks(TypeCheck::strings(), TypeCheck::arrays());
        $this->assertSame('strings arrays', $this->object->getTypeDescription());
    }
}
