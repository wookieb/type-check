<?php

namespace Wookieb\TypeCheck\Tests;

use Wookieb\TypeCheck\TraversableOf;
use Wookieb\TypeCheck\TypeCheck;

class TraversableOfTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TraversableOf
     */
    private $object;

    protected function setUp()
    {
        $this->object = new TraversableOf(TypeCheck::strings());
    }

    public function acceptsArraysAndTraversableObjectsProvider()
    {
        return array(
            'arrays' => array(array('foo', 'bar'), true),
            'traversable' => array(new \ArrayIterator(array('foo', 'bar')), true),
            'objects' => array(new \stdClass(), false),
            'strings' => array('foobar', false)
        );
    }

    /**
     * @dataProvider acceptsArraysAndTraversableObjectsProvider
     */
    public function testAcceptsArraysAndTraversableObjects($data, $result)
    {
        $this->assertSame($result, $this->object->isValidType($data));
    }

    public function testInvalidDataIfContainsInvalidValues()
    {
        $this->assertFalse($this->object->isValidType(range(1, 5)));
    }

    public function testGetTypeDescription()
    {
        $this->assertSame('traversable structures that contains strings', $this->object->getTypeDescription());
    }
}
