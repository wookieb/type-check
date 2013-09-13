# Type check

[![Build Status](https://travis-ci.org/wookieb/type-check.png?branch=master)](https://travis-ci.org/wookieb/type-check)
Provide objects oriented and more abstract way to check the type of data.

Note! This library it's not a replacement for functions is_* and other type check functions!

## Use cases
 * type constraints for validators
 * definition of type for containers, maps https://github.com/wookieb/map

## Install
Via composer
```yaml
    "require": {
        "wookieb/type-check": "0.*"
    }
```

## Usage

```php
use Wookieb\TypeCheck\SimpleTypeCheck;
use Wookieb\TypeCheck\ObjectTypeCheck;
use Wookieb\TypeCheck\MultipleTypesCheck;

$string = new SimpleTypeCheck('string'); // accepts only string
$exceptions = new ObjectTypeCheck('\Exception'); // accepts every object that is instance of \Exception
$onlyPureExceptions = new ObjectTypeCheck('\Exception', true); // accepts only \Exception objects (not children)
$multi = new MultipleTypesCheck($string, $exceptions);

$string->isValidType('foo'); // true
$string->isValidType(true); // false
echo $string->getTypeDescription(); // strings

$exceptions->isValidType(new \InvalidArgumentException('foo')); // true
$exceptions->isValidType(null); // false
echo $exceptions->getTypeDescription(); // instances of Exception

$onlyPureExceptions->isValidType(new \Exception('foo')); // true
$onlyPureExceptions->isValidType(new \InvalidArgumentException('foo')); // false
echo $onlyPureExceptions->getTypeDescription(); // objects of class Exception

$multi->isValidType(new \InvalidArgumentException('foo')); // true
$multi->isValidType('foo'); // true
$multi->isValidType(array()); // false
echo $multi->getTypeDescription(); // strings, instances of Exception
```

## Memory usage

You don't need to always create objects of SimpleTypeCheck for common data types.
Instead you can use an singleton instance for each basic type.

```php
TypeCheck::strings();
TypeCheck::integers();
TypeCheck::floats();
TypeCheck::objects();
TypeCheck::booleans();
TypeCheck::arrays();
TypeCheck::resources();
```

# Other type checks

## TraversableOf
Allows to check the type of traversable (arrays or instances of \Traversable interface) elements

```php
use Wookieb\TypeCheck\TraversableOf;
use Wookieb\TypeCheck\TypeCheck;

$check = new TraversableOf(TypeCheck::strings());
$check->isValidType(array(1, 'foo', 3)); // false
$check->isValidType(array('foo', 'bar', 'zee')); // true
echo $check->getTypeDescription(); // traversable structures that contains strings
```

## CallbackTypeCheck
Uses callback as validation function

```php
use Wookieb\TypeCheck\CallbackTypeCheck;

$check = new CallbackTypeCheck(function ($value) {
    return is_array($value) && reset($value) === 'foo';
}, 'arrays with foo string');

$check->isValidType(array('bar')); // false
$check->isValidType(array('foo')); // true
echo $check->getTypeDescription(); // arrays with foo string
```

## AllChecks
Value must pass all defined type check

```php
use Wookieb\TypeCheck\TraversableOf;
use Wookieb\TypeCheck\TypeCheck;
use Wookieb\TypeCheck\AllChecks;

// narrow the field of "traversable" data types to arrays
$check = new AllChecks(TypeCheck::arrays(), new TraversableOf(TypeCheck::strings()));
$check->isValidType(new ArrayIterator(array('foo', 'bar'))); // false
$check->isValidType(array('foo', 'bar')); // true
echo $check->getTypeDescription(); // arrays traversable structures that contains strings
```

# Changelog

## 0.2
* added AllChecks, CallbackTypeCheck, TraversableOf
