<?php

namespace Wookieb\TypeCheck\Tests;

use Wookieb\TypeCheck\CallbackTypeCheck;

class CallbackTypeCheckTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CallbackTypeCheck
     */
    private $object;

    protected function setUp()
    {
        $this->object = new CallbackTypeCheck('is_string', 'my strings');
    }

    public function testCallbackMustBeCallable()
    {
        $this->setExpectedException('\InvalidArgumentException', 'Callback must be a callable');
        new CallbackTypeCheck(true);
    }

    public function testIsValidType()
    {
        $this->assertTrue($this->object->isValidType('foo'));
        $this->assertFalse($this->object->isValidType(true));
    }

    public function testGetTypeDescription()
    {
        $this->assertSame('my strings', $this->object->getTypeDescription());
    }

}
