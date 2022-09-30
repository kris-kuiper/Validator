Modern PHP Validator - Standalone Validation on Steroids
====================

[![Latest Stable Version](http://poser.pugx.org/kris-kuiper/validator/v)](https://packagist.org/packages/kris-kuiper/validator)
[![License](http://poser.pugx.org/kris-kuiper/validator/license)](https://packagist.org/packages/kris-kuiper/validator)
[![PHP Version Require](http://poser.pugx.org/kris-kuiper/validator/require/php)](https://packagist.org/packages/kris-kuiper/validator)
[![codecov](https://codecov.io/gh/kris-kuiper/validator/branch/master/graph/badge.svg)](https://codecov.io/gh/kris-kuiper/validator)

- [Introduction](#introduction)
- [Head first example](#head-first-example)
- [Installation](#installation)
- [Adding fields for validation](#adding-fields-for-validation)
- [Execute validation](#execute-validation)
  - [Execute, fails and passes](#execute-fails-and-passes)
  - [Re-validate](#re-validate)
- [Validating arrays](#validating-arrays)
- [Special "required" rules](#special-"required"-rules)
  - [Required](#required)
  - [Required with](#required-with)
  - [Required with all](#required-with-all)
  - [Required without](#required-without)
  - [Required without all](#required-without-all)
- [Stopping on first validation failure (bail)](#stopping-on-first-validation-failure-(bail))
- [Validation rules](#validation-rules)
- [Custom validation rules](#custom-validation-rules)
  - [Using rule objects](#using-rule-objects)
  - [Using closures](#using-closures)
- [Conditionally adding rules](#conditionally-adding-rules)
- [Combining fields for validation](#combining-fields-for-validation)
  - [Combining with the glue method](#combining-with-the-glue-method)
  - [Combining with the format method](#combining-with-the-format-method)
- [Working with error messages](#working-with-error-messages)
  - [Check if one or multiple fields have errors](#check-if-one-or-multiple-fields-have-errors)
  - [Working with error objects](#working-with-error-objects)
  - [Setting custom error messages](#setting-custom-error-messages)
- [Working with validated data](#working-with-validated-data)
  - [Returning only validated data](#returning-only-validated-data)
  - [Filter validated data](#filter-validated-data)
- [Field name aliases](#field-name-aliases)
- [Using Blueprints](#using-blueprints)
- [Using middleware](#using-middleware)
  - [Predefined middleware](#predefined-middleware)
  - [Custom middleware](#custom-middleware)
- [Using validation storage](#using-validation-storage)
- [Examples](#examples)
  - [Validating registration form](#example-1-validating-registration-form)
  - [Password validation](#example-2-password-validation)
  - [Combining multiple date fields for single validation](#example-3-combining-multiple-date-fields-for-single-validation)
  - [Using blueprints](#example-4-using-blueprints)
- [License](#license)



## Introduction
Validating incoming data or array's (i.e. POST data) should not be hard. Meet Modern PHP Validator which does the trick nice, clean and easy.

Here are a couple of the many perks:

- 80+ predefined validation rules;
- 15+ predefined [middleware](#predefined-middleware) or [create your own](#custom-middleware) custom middleware;
- No new syntax you need to learn as in the case with i.e. Laravel Validator. Your editor/IDE can complete every validation rule, custom message, middleware, etc. out of the box;
- Easy [retrieving the validated data](#working-with-validated-data) after validation;
- [Combine](#combining-fields-for-validation) multiple fields as one for single validation (i.e. day, month, year inputs as a single date field for validation);
- Use validation [blueprints](#using-blueprints) to extend other validators for [DRY](https://en.wikipedia.org/wiki/Don%27t_repeat_yourself) method;
- Define you [own validation rules](#custom-validation-rules) and [custom error messages](#setting-custom-error-messages).



Modern PHP Validator provides several approaches to validate your application's (incoming) data. It makes it a breeze to validate form submit values as combining multiple input for single validation. It supports middleware and custom validation rules and error messages. It will also return the validated data to insert the data into i.e. a database.

## Head first example:

```php
$data = [
    'department' => 'office',
    'color' => 'black',
    'programmer' => [
        'name' => 'Morris',
        'email' => 'morris@domain.com'
    ],
];

$validator = new Validator($data);

//Select department and color field and attach rules
$validator->field('department', 'color')->required(false)->isString()->lengthBetween(5, 20);

//Select email field within the programmer array and attach rules
$validator->field('programmer.email')->required()->email()->lengthMax(50);

if($validator->passes()) {
    //Validation passes
}
```

And this is just the beginning...



## Installation

Modern PHP Validator is available on Packagist (using semantic versioning). Installation via [Composer](https://getcomposer.org/) is the recommended way.

Run:
```shell script
composer require kris-kuiper/validator
```

Or add this line to your composer.json file:
```shell script
"kris-kuiper/validator": "^1.2"
```




# Let's begin

First things first: <u>rules are executed in the order they are defined</u>.



## Adding fields for validation

By using the `field()` method, you can add one or more field names for validation.

##### Example 1:

Add one or combine multiple fields to attach rules and more:

```php
use KrisKuiper\Validator\Validator;

$input = ['username' => '', 'password' => '', 'email' =>> ''];

$validator = new Validator($input);

//You can add a single field name
$validator->field('username')->required();

//Or add multiple field names
$validator->field('username', 'password', 'email')->required();
```



##### Using wildcards:

You can also use wildcards:

```php
$data = [
    'programmers' => [
        'name' => 'Morris',
        'email' => 'morris@domain.com'
    ],
    'developers' => [
        'name' => 'Smith',
        'email' => 'smith@domain.com'
    ]
];

$validator = new Validator($data);

//Select every email field within an array using wildcards and attach rules
$validator->field('*.email')->required()->email()->lengthMax(50);
```



## Execute validation

#### Execute, fails and passes

The validator comes with an arsenal of built-in validation rules. To execute validation, you may use the `execute()`, `fails()` or `passes()` method.

```php
$validator->field('username')->lengthMin(5)->lengthMax(20);

$passes = $validator->execute(); //Returns bool false/true

if($validator->fails()) {
    //Validation fails
}

if($validator->passes()) {
    //Validation success
}
```

The validator will only run once to avoid i.e. multiple database lookups when executing the `execute()`, `fails()` or `passes()` methods.



#### Re-validate

By default, the validator caches the validation result. So if you run the same validator again, the validator won't run all the rules, middleware, etc. It will directly return the result of the previous run.

To run the validator with all rules, middleware, etc. again, you can use the `revalidate()` method:

```php
$executed = 0;
$validator = new Validator(['username' => 'Morris']);

$customRule = static function () use (&$executed) {

    $executed++;
    return true;
};

$validator->custom('check-username', $customRule);
$validator->field('username')->custom('check-username');

//Execute validation
$validator->execute();
var_dump($executed); //1

//Executing the validation again will have the same result
$validator->execute();
var_dump($executed); //Still 1

//Rerun the validation with all rules, middleware, etc.
$validator->revalidate();
var_dump($executed); //2
```



## Validating arrays

You can also validate an `array` of fields. You can validate all the single elements in an `array` by using a `*` character. It's not mandatory, but recommended to validate the array as an `array` as well for proper error messages.

##### Example

```php
$input = [
    'emails' => [
        'john@example.com', 
        'smith@example.com',
        'morris@example.com',
    ]
];

$validator = new Validator($input);

$validator->field('email')->isArray(); //Check if the value is in array
$validator->field('email.*')->email(); //Each value should be a valid email address
```



## Special "required" rules

Before explaining all the rules, you need to know the existence of the special "required" rules. These rules are special because they can disable (bail) other rules based on if the input is empty or not.

A field is considered "empty" if one of the following conditions are true:

- The value is `null`;
- The value is an empty `string`;
- The value is an empty `array` or empty `countable` object.



#### Required

The field under validation must be present in the input data and not empty.

In this example, the `minLength()` rule will not be executed, because the `required()` method prevents the `minLength` rule to be executed (bailing), due to the fact that the surname is considered `empty`.



##### Example 1:

```php
$data = ['surname' => ''];
$validator = new Validator($data);
$valdiator->field('surname')->required()->lengthMin(5);
```

*Note: validation will fail in this example, because the surname is required, but not provided*.



##### Example 2:

This validation will pass because the surname is only checked with the `minLength` rule when the field is not empty (which it is):

```php
$data = ['surname' => ''];
$validator = new Validator($data);
$valdiator->field('surname')->required(false)->lengthMin(5);
```



#### Required with

The field under validation must be present and not empty *only if* any of the other specified fields are present and not empty.

```php
$data = [
    'surname' => '', 
    'middle_name' => 'Elizabeth', 
    'lastname' => ''
];

$validator = new Validator($data);
$valdiator->field('surname')->requiredWith('middle_name', 'lastname');
```

*Note: validation will fail in this example, because the surname is required because of the middle name field, but it is not provided*.



#### Required with all

The field under validation must be present and not empty *only if* all the other specified fields are present and not empty.

```php
$data = [
    'age' => null,
    'name' => 'Brenda',
    'date' => [
        'day' => 1,
        'month' => null,
        'year' => 2000
    ]
];

$validator = new Validator($data);
$validator->field('age')->requiredWithAll('name', 'date.*');
```

*Note: validation will pass in this example, because the month field is empty, so the age field is not required*.



#### Required without

The field under validation must be present and not empty *only when* any of the other specified fields are empty or not present.

```php
$data = [
    'age' => '',
    'name' => 'Morris',
];

$validator = new Validator($data);
$validator->field('age')->requiredWithout('name');
```

*Note: validation will pass in this example, because the name field is not empty, so the age field is not required*.



#### Required without all

The field under validation must be present and not empty *only when* all the other specified fields are empty or not present.

```php
$data = [
    'name' => '',
    'hobby' => 'Puzzle',
    'age' => 67
];

$validator = new Validator($data);
$validator->field('name')->requiredWithoutAll('hobby', 'age');
```

*Note: validation will pass in this example, because the hobby and age fields are not empty, so the name field is not required*.



## Stopping on first validation failure (bail)

Sometimes you may wish to stop running validation rules on an attribute after the first validation failure. To do so, you can use the `bail()` method.

```php
$validator->field('fieldName')->bail()->min(1)->max(5);
```

This will prevent that the `max` rule is executed if the `min` rule fails validation.



*Unlike all other rules*, the order of the `bail` method does not matter. The example below will have the same result as the example above:

```php
$validator->field('fieldName')->min(1)->max(5)->bail();
```



## Validation rules

Below is a list with all predefined validation rules.

|                                              |                                   |                                               |
|----------------------------------------------|-----------------------------------|-----------------------------------------------|
| [Accepted](#accepted)                        | [Digits max](#digits-max)         | [MAC address](#mac-address)                   |
| [Accepted if](#accepted-if)                  | [Digits min](#digits-min)         | [Max](#max)                                   |
| [AcceptedNotEmpty](#accepted-not-empty)      | [Distinct](#distinct)             | [Min](#min)                                   |
| [After](#after)                              | [Email](#email)                   | [Not in](#not-in)                             |
| [After or equal](#after-or-equal)            | [Ends not with](#ends-not-with)   | [Number](#number)                             |
| [Alpha](#alpha)                              | [Ends with](#ends-with)           | [Present](#present)                           |
| [Alpha dash](#alpha-dash)                    | [Equals](#equals)                 | [Regex](#regex)                               |
| [Alpha numeric](#alpha-numeric)              | [In](#in)                         | [Required](#required)                         |
| [Before](#before)                            | [IP](#ip)                         | [Required with](#required-with)               |
| [Before or equal](#before-or-equal)          | [IP private](#ip-private)         | [Required with all](#required-with-all)       |
| [Between](#between)                          | [IP public](#ip-public)           | [Required without](#required-without)         |
| [Contains](#contains)                        | [IP v4](#ip-v4)                   | [Required without all](#required-without-all) |
| [Contains not](#contains-not)                | [IP v6](#ip-v6)                   | [Same](#same)                                 |
| [Contains letter](#contains-letter)          | [Is array](#is-array)             | [Scalar](#scalar)                             |
| [Contains mixed  case](#contains-mixed-case) | [Is bool](#is-boolean)            | [Starts not with](#starts-not-with)           |
| [Contains number](#contains-number)          | [Is empty](#is-empty)             | [Starts with](#starts-with)                   |
| [Contains symbol](#contains-symbol)          | [Is false](#is-false)             | [Time zone](#time-zone)                       |
| [Count](#count)                              | [Is int](#is-int)                 | [Url](#url)                                   |
| [Countable](#countable)                      | [Is not null](#is-not-null)       | [UUID](#uuid)                                 |
| [Count between](#count-between)              | [Is null](#is-null)               | [UUID v1](#uuid-v1)                           |
| [Count max](#count-max)                      | [Is string](#is-string)           | [UUID v3](#uuid-v3)                           |
| [Count min](#count-min)                      | [Is true](#is-true)               | [UUID v4](#uuid-v4)                           |
| [Date](#date)                                | [Json](#json)                     | [UUID v5](#uuid-v5)                           |
| [Different](#different)                      | [Length](#length)                 | [Words](#words)                               |
| [Different with all](#different-with-all)    | [Length between](#length-between) | [Words max](#words-max)                       |
| [Digits](#digits)                            | [Length max](#length-max)         | [Words min](#words-min)                       |
| [Digits between](#digits-between)            | [Length min](#length-min)         |                                               |


##### Accepted

Checks if the data under validation is accepted. By default, the field under validation must be *yes*, *on*, *1*, or *true*. This is useful for validating "Terms of Service" acceptance.

```php
$valdiator->field('fieldName')->accepted();
```

You may also pass an array with values which are considered accepted:
```php
$valdiator->field('fieldName')->accepted(['accept', 'agree', 'ok']);
```



##### Accepted if

The field under validation must be "yes", "on", "1", "true", `1`, or `true` if another field's value is equal to a given value.

```php
$data = ['field' => 'yes', 'other_field' => 'foo'];
$validator = new Validator($data);

$valdiator->field('fieldName')->acceptedIf('other_field', 'foo');
```

You may also provide the values which should be considered as accepted:
```php
$valdiator
    ->field('fieldName')
    ->acceptedIf('other_field', 'foo', ['accepted', 'agreed', 'checked']);
```

See also the [Accepted](#accepted) and [Accepted not empty](#accepted-not-empty) rules.



##### Accepted not empty

The field under validation must be "yes", "on", "1", "true", `1`, or `true` if another field's value is not empty.

```php
$data = ['field' => 'yes', 'other_field' => 'foo'];
$validator = new Validator($data);

$valdiator->field('fieldName')->acceptedNotEmpty('other_field');
```

You may also provide the values which should be considered as accepted:
```php
$valdiator
    ->field('fieldName')
    ->acceptedNotEmpty('other_field', ['accepted', 'agreed', 'checked']);
```

See also the [Accepted](#accepted) and [Accepted if](#accepted-if) rules.



##### After

Checks if the data under validation comes after a given date.

```php
$valdiator->field('fieldName')->after('2000-01-01', 'Y-m-d');
```
See also the [Before](#before), [Before or equal](#before-or-equal) and [After or equal](#after-or-equal) rules.



##### After or equal

Checks if the data under validation comes after or is equal to a given date.

```php
$valdiator->field('fieldName')->afterOrEqual('2000-01-01', 'Y-m-d');
```
See also the [After](#after), [Before or equal](#before-or-equal) and [Before](#before) rules.



##### Alpha

Checks if the field under validation only contains alpha characters (a-z and A-Z).

```php
$valdiator->field('fieldName')->alpha();
```



##### Alpha dash

Checks if the field under validation only contains letters and numbers, dashes and underscores.

```php
$valdiator->field('fieldName')->alphaDash();
```



##### Alpha numeric

Checks if the field under validation only exists off letters and numbers.

```php
$valdiator->field('fieldName')->alphaNumeric();
```



##### Before

Checks if the data under validation comes before a given date.

```php
$valdiator->field('fieldName')->before('2030-01-01', 'Y-m-d');
```
See also the [After](#after), [Before or equal](#before-or-equal) and [After or equal](#after-or-equal) rules.



##### Before or equal

Checks if the data under validation comes before or is equal to a given date.

```php
$valdiator->field('fieldName')->beforeOrEqual('2030-01-01', 'Y-m-d');
```
See also the [After](#after), [After or equal](#after-or-equal) and [Before](#before) rules.



##### Between

Checks if the data under validation (number) is between a given minimum and maximum.

```php
$valdiator->field('fieldName')->between(5, 10.5);
```



##### Contains

Checks if the data under validation contains a given value.

```php
$valdiator->field('fieldName')->contains('abc');
```

Use the second parameter to search case-sensitive:
```php
$valdiator->field('fieldName')->contains('ABC', true);
```

See also the [Contains not](#contains-not) rule.



##### Contains not

Checks if the data under validation does not contain a given value.

```php
$valdiator->field('fieldName')->containsNot('ABC');
```

Use the second parameter to search case-sensitive:

```php
$valdiator->field('fieldName')->containsNot('ABC', true);
```

See also the [Contains](#contains) rule.



##### Contains letter

Checks if the data under validation has at least one letter.

```php
$valdiator->field('fieldName')->containsLetter();
```



##### Contains mixed case

Checks if the data under validation has at least one uppercase and one lowercase letter.

```php
$valdiator->field('fieldName')->containsMixedCase();
```



##### Contains number

Checks if the data under validation has at least one number.

```php
$valdiator->field('fieldName')->containsNumber();
```



##### Contains symbol

Checks if the data under validation has at least one symbol.

```php
$valdiator->field('fieldName')->containsSymbol();
```



##### Count

Checks if the data under validation contains a given amount of items.

```php
$valdiator->field('fieldName')->count(10);
```



##### Countable

Checks if the data under validation is countable.

```php
$valdiator->field('fieldName')->countable();
```



##### Count between

Checks if the data under validation contains an amount of items between a given minimum and maximum.

```php
$valdiator->field('fieldName')->countBetween(5, 10);
```



##### Count max

Checks if the data under validation contains no more items than a given maximum amount.

```php
$valdiator->field('fieldName')->countMax(10);
```



##### Count min

Checks if the data under validation contains at least a given amount of items.

```php
$valdiator->field('fieldName')->countMin(5);
```



##### Date

Checks if the data under validation is a valid date.

```php
$valdiator->field('fieldName')->date('Y-m-d');
```



##### Different

Check if the data under validation does not match one of the values of one or more fields.

```php
$valdiator->field('fieldName')->different('otherFieldName', 'anotherFieldName');
```



##### Different with all

Check if the data under validation does not match all the values of one or more fields.

```php
$valdiator->field('fieldName')->differentWithAll('otherFieldName', 'anotherFieldName');
```



##### Digits

Check if an integer value have exact length of provided digits.

```php
$valdiator->field('fieldName')->digits(5);
```



##### Digits between

Check if an integer value is between the provided min and max length of digits.

```php
$valdiator->field('fieldName')->digitsBetween(4, 6);
```



##### Digits max

Check if an integer value has a maximum length of digits.

```php
$valdiator->field('fieldName')->digitsMax(5);
```



##### Digits min

Check if an integer value has at least the provided length of digits.

```php
$valdiator->field('fieldName')->digitsMin(5);
```



##### Distinct

Check if all the values in an array are unique

```php
$valdiator->field('fieldName')->distinct();
```



##### Email

Checks if the data under validation is a valid email address.

```php
$valdiator->field('fieldName')->email();
```



##### Ends not with

Checks if the data under validation does not end with a given value.

```php
$valdiator->field('fieldName')->endsNotWith('abc');
```

Use the second parameter to match case-sensitive:
```php
$valdiator->field('fieldName')->endsNotWith('ABC', true);
```

See also the [Ends with](#ends-with), [Starts with](#starts-with) and [Starts not with](#starts-not-with) rules.



##### Ends with

Checks if the data under validation ends with a given value.

```php
$valdiator->field('fieldName')->endsWith('abc');
```

Use the second parameter to match case-sensitive:
```php
$valdiator->field('fieldName')->endsWith('ABC', true);
```

See also the [Ends not with](#ends-not-with), [Starts with](#starts-with) and [Starts not with](#starts-not-with) rules.



##### Equals

Checks if the data under validation equals a provided value.

```php
$valdiator->field('fieldName')->equals('abc');
```

Use the second parameter to match case-sensitive:
```php
$valdiator->field('fieldName')->equals('ABC', true);
```



##### In

Checks if the data under validation exists in a given array.

```php
$valdiator->field('fieldName')->in(['foo', 'bar']);
```

Use the second parameter to search type safe:
```php
$valdiator->field('fieldName')->in(['123', 123], true);
```

See also the [Not in](#not-in) rule.



##### IP

Checks if the data under validation is a valid IP address (v4 or v6).

```php
$valdiator->field('fieldName')->ip();
```



##### IP private

Checks if the data under validation is a private IP address (v4 or v6).

```php
$valdiator->field('fieldName')->ipPrivate();
```



##### IP public

Checks if the data under validation is a public ip address (v4 or v6).

```php
$valdiator->field('fieldName')->ipPublic();
```



##### IP v4

Checks if the data under validation is a valid IP v4 address.

```php
$valdiator->field('fieldName')->ipv4();
```



##### IP v6

Checks if the data under validation is a valid IP v6 address.

```php
$valdiator->field('fieldName')->ipv6();
```



##### Is array

Checks if the data under validation is an array.

```php
$valdiator->field('fieldName')->isArray();
```



##### Is boolean

Checks if the data under validation is a boolean `true` or `false`.

```php
$valdiator->field('fieldName')->isBool();
```



##### Is empty

Checks if the data under validation is empty. Empty string, empty array and null are considered empty.

```php
$valdiator->field('fieldName')->isEmpty();
```



##### Is false

Checks if the data under validation is boolean `false`.

```php
$valdiator->field('fieldName')->isFalse();
```



##### Is int

Checks if the data under validation is an integer number.

```php
$valdiator->field('fieldName')->isInt();
```

You can use the strict parameter to strictly check if a value is an integer number:
```php
$valdiator->field('fieldName')->isInt(true);
```



##### Is not null

Checks if the data under validation is not `null`.

```php
$valdiator->field('fieldName')->isNotNull();
```

See also the [Is null](#is-null) rule.



##### Is null

Checks if the data under validation is `null`.

```php
$valdiator->field('fieldName')->isNull();
```

See also the [Is not null](#is-not-null) rule.



##### Is string

Checks if the data under validation is of the type string.

```php
$valdiator->field('fieldName')->isString();
```



##### Is true

Checks if value equals boolean `true`.

```php
$valdiator->field('fieldName')->isTrue();
```



##### JSON

Checks if the data under validation is valid JSON.

```php
$valdiator->field('fieldName')->json();
```



##### Length

Checks if the value character length is the given length.

```php
$valdiator->field('fieldName')->length(10);
```



##### Length between

Checks if the data under validation is a valid URL.

```php
$valdiator->field('fieldName')->lengthBetween(10, 20);
```



##### Length max

Checks if the amount of characters is less or equal than the given amount.

```php
$valdiator->field('fieldName')->lengthMax(10);
```

##### 

##### Length min

Checks if the amount of characters is at least a given amount.

```php
$valdiator->field('fieldName')->lengthMin(5);
```



##### MAC address

Checks if the data under validation is a valid MAC address. By default, the dash "-" symbol is used as the delimiter for a valid MAC address.

```php
$valdiator->field('fieldName')->macAddress();
```

You can change the delimiter i.e. colon:
```php
$valdiator->field('fieldName')->macAddress(':');
```



##### Max

Checks if the value is less than the given maximum amount.

```php
$valdiator->field('fieldName')->max(10.5);
```



##### Min

Checks if the field under validation is at least a given minimum.

```php
$valdiator->field('fieldName')->min(10.5;
```



##### Not in

Checks if the data under validation exists in a given array.

```php
$valdiator->field('fieldName')->notIn(['foo', 'bar']);
```

Use the second parameter to search type safe:

```php
$valdiator->field('fieldName')->notIn(['123', 123], true);
```



##### Number

Checks if the data under validation is an integer number.

```php
$valdiator->field('fieldName')->number();
```

You can use the strict parameter to strictly check if a value is a number:
```php
$valdiator->field('fieldName')->number(true);
```



##### Present

Check if the data under validation exists as key.

```php
$valdiator->field('fieldName')->present();
```



##### Regex

Check if value matches a regular expression pattern.

```php
$valdiator->field('fieldName')->regex('/[a-z]+/');
```



##### Required

Adds a new rule that will require the field/value (null, '', [] are considered empty).

```php
$valdiator->field('fieldName')->required();
```



##### Required with

The field under validation must be present and not empty only if one of the other specified fields are present or empty.

```php
$valdiator->field('fieldName')->requiredWith(string ...$fieldNames);
```



##### Required with all

The field under validation must be present and not empty only if all the other specified fields are present or empty.

```php
$valdiator->field('fieldName')->requiredWithAll(string ...$fieldNames);
```



##### Required without

The field under validation must be present and not empty only if one of the other specified fields are not present or empty.

```php
$valdiator->field('fieldName')->requiredWithout(string ...$fieldNames);
```



##### Required without all

The field under validation must be present and not empty only if all the other specified fields are not present or empty.

```php
$valdiator->field('fieldName')->requiredWithoutAll(string ...$fieldNames);
```



##### Same

Check if value matches a value of a given field name.

```php
$valdiator->field('password')->same('password-repeat');
```



##### Scalar

Checks if the data under validation is a scalar type.

```php
$valdiator->field('fieldName')->scalar();
```



##### Starts not with

Checks if the data under validation does not begin with a given value.

```php
$valdiator->field('fieldName')->startsNotWith('abc');
```

Use the second parameter to search case-sensitive:

```php
$valdiator->field('fieldName')->startsNotWith('ABC', true);
```

See also the [Starts with](#starts-with), [Ends with](#ends-with) and [Ends not with](#ends-not-with) rules.



##### Starts with

Checks if the data under validation begins with a given value.

```php
$valdiator->field('fieldName')->startsWith('abc');
```

Use the second parameter to search case-sensitive:

```php
$valdiator->field('fieldName')->startsWith('ABC', true);
```

See also the [Ends with](#ends-with), [Ends not with](#ends-not-with) and [Starts not with](#starts-not-with) rules.



##### Time zone

Checks if the data under validation is a valid time zone.

```php
$valdiator->field('fieldName')->timezone();
```

Use the first parameter to search case-insensitive:
```php
$valdiator->field('fieldName')->timezone(true);
```


*Note: see [timezones](https://www.php.net/manual/en/datetimezone.listidentifiers.php) on php.net for more information.*



##### URL

Checks if the data under validation is a valid URL. By default, the protocol will not be checked.

```php
$valdiator->field('fieldName')->url();
```

Force the protocol (i.e. http or https):
```php
$valdiator->field('fieldName')->url(true);
```



##### UUID

Checks if the data under validation is a valid UUID v1, v3, v4 or v5 entity.

```php
$valdiator->field('fieldName')->uuid();
```



##### UUID v1

Checks if the data under validation is a valid UUID v1 entity.

```php
$valdiator->field('fieldName')->uuidv1();
```



##### UUID v3

Checks if the data under validation is a valid UUID v3 entity.

```php
$valdiator->field('fieldName')->uuidv3();
```



##### UUID v4

Checks if the data under validation is a valid UUID v4 entity.

```php
$valdiator->field('fieldName')->uuidv4();
```



##### UUID v5

Checks if the data under validation is a valid UUID v4 entity.

```php
$valdiator->field('fieldName')->uuidv5();
```



##### Words

Checks if the amount of words is at least to a given amount. By default, a word is defined to have two or more alphanumeric characters.

```php
$valdiator->field('fieldName')->words(10);
```

The second parameter defines the minimum length of the word, while the third parameter can be used to allow all symbols instead of only alphanumeric characters:

```php
$valdiator->field('fieldName')->words(10, 5, false);
```

See also the [Words max](#words-max) and [Words min](#words-min) rules.



##### Words max

Checks if the amount of words is less than or equal to a given amount. By default, a word is defined to have two or more alphanumeric characters.

```php
$valdiator->field('fieldName')->wordsMax(10);
```

The second parameter defines the minimum length of the word, while the third parameter can be used to allow all symbols instead of only alphanumeric characters:
```php
$valdiator->field('fieldName')->wordsMax(10, 5, false);
```



##### Words min

Checks if the amount of words is more than or equal to a given amount. By default, a word is defined to have two or more alphanumeric characters.

```php
$valdiator->field('fieldName')->wordsMin(10);
```

The second parameter defines the minimum length of the word, while the third parameter can be used to allow all symbols instead of only alphanumeric characters:
```php
$valdiator->field('fieldName')->wordsMin(10, 5, false);
```



## Custom validation rules

#### Using rule objects

Although there is a large number of predefined validation rules, you may wish to specify some of your own. One method of registering custom validation rules is using rule objects.

Below is a blueprint/example of a custom rule:

```php
use KrisKuiper\Validator\Blueprint\Contracts\RuleInterface;
use KrisKuiper\Validator\Blueprint\Custom\Current;

class CustomRule implements RuleInterface
{
    public const RULE_NAME = 'length';
    
    public function getName(): string
    {
        return self::RULE_NAME;
    }

    public function isValid(Current $current): bool
    {
        return strlen($current->getValue()) >= $current->getParameter('min');
    }

    public function getMessage(): string
    {
        return 'Invalid input';
    }
}
```



Once the rule has been defined, you may attach it to the validator by calling the `loadRule()` method, passing an instance of the rule object. Then you can call the `custom()` method which takes the name of the custom rule (which is defined in the `getName()` method of the custom rule object) as first parameter. An  optional second parameter is for all the parameters which you can use in your custom rule:

```php
use KrisKuiper\Validator\Validator;

$data = ['name' => 'Morris'];
$validator = new Validator($data);

//Attach the custom rule
$validator->loadRule(new CustomRule());

//Use the custom rule
$validator->field('name')->custom(CustomRule::RULE_NAME, ['min' => 5]); 

//Set an optional custom error message
$validator
    ->messages('name')
    ->custom('length', 'Invalid value, at least :min characters'); 

if($validator->passes()) {
 	//Validation passes   
}
```



*Note 1: The name `length` equals the output of the `getName()` method from the rule object.*

*Note 2: The error message will be used from the `getMessage()` method from the rule object, unless you set an optional custom error message like in the example above.*

*Note 3: You can also set [custom error messages](#example-5-using-custom-error-messages-within-custom-rules) with the `message()` method.*



#### Using closures

If you only need the functionality of a custom rule once throughout your application, you may use a `closure function` instead of a rule object:

```php
use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Blueprint\Custom\Current;

$data = ['name' => 'Morris'];
$validator = new Validator($data);

//Attach the custom rule
$validator->custom('length', function (Current $current) {
    return strlen($current->getValue()) > $current->getParameter('min');
});

//Use the custom rule
$validator
    ->field('name')
    ->custom('length', ['min' => 5]);

//Set the error message
$validator
    ->messages('name')
    ->custom('length', 'Invalid value, at least :min characters');

if($validator->passes()) {
    //Validation passes   
}
```
*Note: You can set [custom error messages](#example-5-using-custom-error-messages-within-custom-rules) within rule closures*


## Conditionally adding rules

Sometimes you may wish to add validation rules based on more complex conditional logic. For example, you may want to validate the incoming data by checking if the amount of products is higher than 99, then the reason of purchase should be filled in.

This can be achieved by using the `conditional()` method:

```php
use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Blueprint\Custom\Current;

$data = [
    'amount' => 100,
    'reason' => null
];

$validator = new Validator($data);
$validator
    ->field('reason')
    ->conditional(function(Current $current) {
        //Retrieve the value of the amount field
        return $current->getValue('amount') > 99;
    })
    ->required()
    ->lengthMax(2000);

$validator->execute());
```

In this example, the validation will fail because the amount is higher than 99, so the reason field is required.

If the amount is below 100, validation will pass.



#### Using multiple conditions

Although the last rule `isString`, in the example below, requires the provided data to be a `string` and the provided age field is an `interger` number (`25`), the validation still succeeds. This is because the last `conditional` rule returns `false`, so the `isString` rule is not executed.

```php
use KrisKuiper\Validator\Validator;
use KrisKuiper\Validator\Blueprint\Custom\Current;

$data = ['age' => 25];
$validator = new Validator($data);

$validator
    ->field('age')
    ->conditional(static function () {
        return true;
    })
    ->min(10) //Should be at least 10
    ->conditional(static function () {
        return true;
    })
    ->max(30) //Should be a maximum of 30
    ->conditional(static function () {
        return false; //This will prevent executing the next rule
    })
    ->isString(); //This rule won't be executed

$validator->execute(); //Returns true
```





## Combining fields for validation

Sometimes you need to check multiple input values as one value i.e. day, month and year into a single date field or a serial code separated into four blocks. Modern PHP Validator lets you combine them into a new value for validation using the `glue()` or `format()` method described below.

##### HTML

```html
<input type="text" name="year" value="1952">
<input type="text" name="month" value="28">
<input type="text" name="day" value="03">
```



#### Combining with the glue method

You can combine fields with the `glue()` method and give it a new field alias (in this case `date`) with the `alias()` method which you can use to specify a new validation rule:

```php
$input = ['year' => '1952', 'month' => '28', 'day' => '03'];

$validator = new Validator($input);
$validator
    ->combine('year', 'month', 'day')
    ->glue('-')
    ->alias('date'); //1952-28-03

$validator
    ->field('date')
    ->date('Y-m-d');
```



#### Combining with the format method

You can also combine multiple fields with the `format()` method for more control:

```php
$input = ['year' => '1952', 'month' => '28', 'day' => '03'];

$validator = new Validator($input);
$validator
    ->combine('year', 'month', 'day')
    ->format(':year/:month/:day')
    ->name('date'); //1952/28/03

$validator
    ->field('date')
    ->date('Y/m/d');
```

Every colon variable i.e. `:year` or `:month` will be replaced with the value of its representing key. This way, you can reuse the variable.



## Working with error messages

Use the `errors()` method to return a `sFire\Validator\Errors\ErrorCollection` object. This object has a couple of methods which you can use to return validation error messages.



#### Check if one or multiple fields have errors

To check if a field has errors, you can use the `has()` method. This method returns a `boolean` and accepts one or more field names. By giving multiple field names, the method will only return `true` if all the field names have errors.

```php
$validator->errors()->has('email'); //Returns boolean true/false
$validator->errors()->has('username', 'password'); //Returns boolean true/false
```

You can also check if there are any errors by calling the `count()`method:

```php
if($validator->errors()->count() > 0) {
    //Validator has errors
}
```



#### Retrieve error messages

The `errors()` method can be used to retrieve a collection of all the errors, optional filtered on a specific field. If the field name parameters is provided, it will return all the errors for this specific field.

Imagine the following validation data and rules:

```php
$data = ['username' => 'abc', 'password' => '', 'password_repeat'];

$validator = new Validator($data);

$validator
    ->field('username')
    ->between(5, 10)
    ->startsWith('def');

$validator
    ->field('password')
    ->same('password_repeat');

$validator->execute();
```



##### Looping through error objects:

See the [Working with error objects](#working-with-error-objects) section for more information about the error object.

```php
foreach($validator->errors() as $error) {
    var_dump($error->getMessage());
}
```

Will output:

```
string(30) "Value must be between 5 and 10"
string(27) "Value must begin with "def""
string(43) "Value should be the same as password_repeat"
```



You can also get all first errors for every unique field name using the `distinct()` method:

```php
foreach($validator->errors()->distinct() as $error) {
    var_dump($error->getMessage());
}
```

Will output:

```
string(30) "Value must be between 5 and 10"
string(43) "Value should be the same as password_repeat"
```



##### Casting the collection to an Array

```php
$validator->errors->toArray();
```

Will return:

```php
Array
(
    [0] => KrisKuiper\Validator\Error Object ...
    [1] => KrisKuiper\Validator\Error Object ...
)
```



#### Working with error objects

Every error within an error collection has a couple of handy methods to return the message, rule name, the value of the field which caused the error and much more.

Imagine the following validation:

```php
$data = ['username' => 'abc'];

$validator = new Validator($data);
$validator->field('username')->lengthBetween(5, 10);
$validator->execute();

//Retrieve the first error
$error = $validator->errors()->first();

//You can also select all the errors for username and then filter for the first one
$error = $validator->errors('username')->first();
```

We now have a single error object stored in the `$error` variable.

This object has several handy methods:



##### Return the error message

Returns the parsed (with variable parameters) error message.

```php
$error->getMessage();
```

This will return:

```
Value should be between 5 and 10 characters long
```



##### Return the unparsed error message

Returns the raw (without variable parameters) error message.

```php
$error->getRawMessage();
```

This will return:

```
Value should be between :minimum and :maximum characters long
```



##### Return the field name

Returns the name of the field that has been validated.

```php
$error->getFieldName();
```

This will return:

```
username
```



##### Return the value of the field

Returns the value that has been validated which causes the error to trigger.

```php
$error->getValue();
```

This will return:

```
abc
```



##### Return the parameters of the rule

Returns the parameters used for validation.

```php
$error->getParameters();
```

This will return:

```php
['minimum' => 5, 'maximum' => 10]
```



##### Return the rule name

Returns the name of the rule used for validation.

```php
$error->getRuleName();
```

This will return:

```php
lengthBetween
```



##### Return the id of the error message

Returns a unique identifier for the error based on the raw error message (fixed 10 characters long).

```php
$error->getId();
```

This will return something similar to:

```php
bcbc349866
```



#### Setting custom error messages
You can set your own custom error messages by using the `messages()` method. This can be handy when using translations. You can overwrite rule messages globally or set a message per rule and field name.


##### Example 1: Overwriting messages globally

```php
$data = [
    'amount' => 4,
    'product' => 'Laptop'
];

$validator = new Validator($data);
$validator
    ->field('amount', 'product')
    ->required();

//Set error message globally for the required rule
$validator
    ->messages()
    ->required('Field is required!'); 
```



##### Example 2: Overwriting messages per field and rule name

```php
$data = [
    'amount' => 4,
    'product' => 'Laptop'
];

$validator = new Validator($data);
$validator->field('amount', 'product')->required();

//Sets the required error messages specific for the amount field
$validator
    ->messages('amount')
    ->required('Amount is required!'); 

//Sets the required error messages specific for the product field
$validator
    ->messages('product')
    ->required('Product is required!'); 
```



##### Example 3: Combination of globally and per field and rule error messages

```php
$data = [
    'amount' => 4,
    'product' => 'Laptop'
];

$validator = new Validator($data);
$validator
    ->field('amount', 'product')
    ->required();

//Sets the required error messages specific for the amount field
$validator
    ->messages('amount')
    ->required('Amount is required'); 

//Set error message globally for the required rule. This will only affect the product field in this example.
$validator
    ->messages()
    ->required('Field is required'); 
```



##### Example 4: Using variables in error messages

You can use the parameters name of the rule as placeholders. For example, the between rule, has two parameters named `$minimum` and `$maximum`. The placeholders will be replaced with their corresponding parameter values.
```php
$data = [
    'amount' => 4,
    'product' => 'Laptop'
];

$validator = new Validator($data);
$validator
    ->field('amount')
    ->between(1, 5); //$minimum and $maximum parameters

$validator
    ->messages('amount')
    ->between('Amount should be between :minimum and :maximum'); 
	//Amount should be between 1 and 5'
```



#### Example 5: Using custom error messages within custom rules
You can set custom error messages within [custom rule closures](#using-closures) or [custom rule objects](#using-rule-objects) using the `message()` method:
```php
$data = ['amount' => 5];

$validator = new Validator($data);

//Define the customer rule
$validator->custom('min10', function (Current $current): bool {

    $current->message('Amount should be at least :min');
    return $current->geValue() >= $current->getParameter('min');
});

//Attach the custom rule to the amount field
$validator->field('amount')->custom('min10', ['min' => 10]);
```


## Working with validated data

#### Returning only validated data

After validation, you can retrieve the data that has been validated. This is different from the given data, because it will only return the data where validation rules were applied.

```php
$data = [
    'username' => 'Morris', 
    'password' => '123'
];

$validator = new Validator($data);
$validator
    ->field('username')
    ->lengthMin(3)
    ->lengthMax(10)
    ->isString();

$validator->execute(); //Without executing, there is no validated data

$validator
    ->validatedData()
    ->toArray(); //Array('username' => 'Morris')
```



#### Filter validated data

You can include or exclude fields from the validated array by using the `not`, `only` and `pluck` methods:

```php
$data = [
    'username' => 'Morris', 
    'email' => 'email@domain.com',
    'password' => '123',
    'interest' => [
        ['title' => 'programming'],
        ['title' => 'coding']
    ]
];

$validator = new Validator($data);

$validator
    ->field('username', 'email', 'password', 'interest.*.title')
    ->required();

$validator->execute();
```



##### Include field names

```php
$validator
    ->validatedData()
    ->only('username', 'email')
    ->toArray();
```

This will return:

```php
array(
    'username' => 'Morris', 
    'email' => 'email@domain.com'
);
```



##### Exclude field names

```php
$validator
    ->validatedData()
    ->not('username', 'email', 'interest')
    ->toArray();
```

This will return:

```php
array('password' => '123');
```



##### Extract multiple columns in key-pair value

```php
$validator
    ->validatedData()
    ->pluck('interest.*.title')
    ->toArray();
```

This will return:

```php
array('programming', 'coding');
```




## Field name aliases
You can give field names aliases. This can be handy if an input field name is different from the name you expect for i.e. your database entity.
```php
use KrisKuiper\Validator\Validator;

$data = [
    'product' => '1850048',
    'code' => '0718037893532',
];

$validator = new Validator($data);

//Create an alias for product and code
$validator->alias('product', 'product_id');
$validator->alias('code', 'ean'); 

//Add rules for the two new aliases
$validator->field('product_id')->isInt()->min(1);
$validator->field('ean')->isString()->length(13);

if($validator->passes()) {
    
    $validator->validatedData()->toArray();
    
    /*
    array(
        'product_id' => '1850048', 
        'ean' => '0718037893532'
    )
    */
}
```
*Note: aliases can also be used in [blueprints](#using-blueprints).*




## Using blueprints

You can define blueprints for validating data. This will prevent code duplication and helps to become [DRY](https://en.wikipedia.org/wiki/Don%27t_repeat_yourself).

In the blueprint, you can define all the common validation rules, error messages, middleware, etc. which you can use to extend.



##### Example 1:

In this example, the `name` and `role` fields should always be validated, but the `email` field is only added to the validator when needed:

```php
use KrisKuiper\Validator\Blueprint\Blueprint;
use KrisKuiper\Validator\Validator;

//Create the validation blueprint
$blueprint = new Blueprint();
$blueprint->field('name')->lengthBetween(2, 30)->required();
$blueprint->field('role')->in(['admin', 'moderator', 'user'])->required();
```



Then use the blueprint in your validator:

```php
$data = [
    'name' => 'Morris',
    'role' => 'moderator',
    'email' => 'morris@email.com'
];

$validator = new Validator($data);

//Use the blueprint in the validator
$validator->loadBlueprint($blueprint); 

//Add extra rules that extend the blueprint
$validator
    ->field('email')
    ->email()
    ->lengthBetween(5, 50);

if($validator->passes()) {
    //Validation passes
}
```



##### Example 2:

You can also define custom error messages, custom validation rules and middleware in a blueprint for later use:

```php
use KrisKuiper\Validator\Blueprint\Blueprint;
use KrisKuiper\Validator\Blueprint\Custom\Current;
use KrisKuiper\Validator\Validator;


//Create the validation blueprint
$blueprint = new Blueprint();

//Attach rules (and custom rules) to the "name" field
$blueprint->field('name')
    ->required()
    ->lengthBetween(2, 30)
    ->custom('morrisRule');

//Define custom error messages
$blueprint
    ->message('name')
    ->required('The name field is required!')
    ->lengthBetween('The name should be between :minimum and :maximum characters long!');

//Attach middleware
$blueprint
    ->middleware('name')
    ->trim();

//Define a custom rule
$blueprint->custom('morrisRule', function (Current $current) {
    return $current->getValue() === 'Morris';
});
```



Then use the blueprint in your validator:

```php
$data = [
    'name' => 'Morris', 
    'email' => 'morris@domain.com'
];

$validator = new Validator($data);

//Use the blueprint in the validator
$validator->loadBlueprint($blueprint);

//Add extra rules that extend the blueprint
$validator
    ->field('email')
    ->email()
    ->lengthBetween(5, 50);

if($validator->passes()) {
    //Validation passes
}
```



## Using middleware

Middleware provides a convenient mechanism to alter the input data before validation. You can trim all whitespace or add a leading zero to date inputs etc. Modern PHP Validator comes with predefined middleware which you can use, or you can create your [own custom middleware](#custom-middleware).

*Note: When retrieving the validated data with the `validatedData()` method, the altered values by the executed middleware will be returned.*

### Predefined middleware

Modern PHP Validator comes with predefined middleware which you can use.



##### Example 1:

In the example below we define the `toLowercase` and `trim` middleware and attach it to all the elements inside the "email" field.

Before a single rule is executed, the middleware will take the value of the field and convert and set the new value for the validation rules to work with.

```php
$data = [
    'emails' => [
        '  MORRIS@domain.com    ', //Note the spaces and capital letters
        ' Smith@domain.com '
    ]
];

$validator = new Validator($data);
$validator->field('emails.*')->email()->lengthBetween(5, 50);

//Attach the to lowercase and trim middleware
$validator
    ->middleware('emails.*')
    ->toLowercase()
    ->trim(); 

if($validator->passes()) {
    
    $validator->validatedData()->toArray();
    /*
	'emails' => [
		'morris@domain.com',
		'smith@domain.com'
	]
    */
}
```

As you can see, the validation passes and the validated data is returning the array with emails converted to lower-case and without spaces around the email addresses.



#### Middleware types:

Below is a list of all the predefined middleware.

##### ABS

Convert numbers to their absolute value.

```php
$valdiator->middleware('field')->abs();
```



##### Ceil

Converts all numbers to the next highest integer value by rounding up the value if necessary and if the value is a number.

```php
$valdiator->middleware('field')->ceil();
```

See also the [Floor](#floor) middleware.



##### Floor
Converts all numbers to the next lowest integer value by rounding up the value if necessary and if the value is a number.

```php
$valdiator->middleware('field')->floor();
```

See also the [Ceil](#ceil) middleware.



##### Leading zero

Prefixes a zero for numbers between 0 and 9.

```php
$valdiator->middleware('field')->leadingZero();
```



##### Ltrim

Strips whitespace (or other characters) from the beginning of a string.

```php
$valdiator->middleware('field')->ltrim();
```

You can also define your own characters set which should be trimmed:

```php
//Trims all the - and * characters
$valdiator->middleware('field')->ltrim('-*');
```

See also the [Trim](#trim) and the [Rtrim](#rtrim) middleware.



##### Replace

Replaces all occurrences of the search string with the replacement string.

```php
//Replaces all "hello" with "hi"
$valdiator->middleware('field')->replace('hello', 'hi'); 
```



##### Round

Rounds the value if the value is a number.

```php
$valdiator->middleware('field')->round();
```

You can also define precision and the mode (see https://www.php.net/round for details)

```php
$valdiator->middleware('field')->round(2, PHP_ROUND_HALF_DOWN);
```



##### Rtrim

Strips whitespace (or other characters) from the end of a string.

```php
$valdiator->middleware('field')->rtrim();
```

You can also define your own characters which should be trimmed:

```php
$valdiator->middleware('field')->rtrim('-|*'); //Trims all the -, | and * characters
```

See also the [Trim](#trim) and the [Ltrim](#ltrim) middleware.



##### Substr

Returns part of a string.

```php
$valdiator->middleware('field')->substr(5, 5);
```

See https://www.php.net/substr for details.



##### To boolean
Converts the value under validation to a boolean.

```php
$valdiator->middleware('field')->toBoolean();
```



##### To float

Converts the value under validation to a float.

```php
$valdiator->middleware('field')->toFloat();
```



##### To int

Converts the value under validation to an integer number.

```php
$valdiator->middleware('field')->toInt();
```



##### To lowercase

Converts the value (if it is a string) under validation to lowercase.

```php
$valdiator->middleware('field')->toLowercase();
```



##### To string

Converts the value under validation to a string.

```php
$valdiator->middleware('field')->toString();
```



##### To uppercase

Converts the value (if it is a string) under validation to uppercase.

```php
$valdiator->middleware('field')->toUppercase();
```



##### Trim

Strips whitespace (or other characters) from the beginning and end of a string.

```php
$valdiator->middleware('field')->trim();
```

You can also define your own characters which should be trimmed:

```php
//Trims all the -, | and * characters
$valdiator->middleware('field')->trim('-|*'); 
```

See also the [Rtrim](#rtrim) and the [Ltrim](#ltrim) middleware.



##### Uppercase first
Makes a string's first character uppercase.

```php
$valdiator->middleware('field')->ucFirst();
```



##### Uppercase words
Makes the first character of each word in a string uppercase.

```php
$valdiator->middleware('field')->ucWords();
```



### Custom middleware

You can also define your own custom middleware.

Below is a blueprint/example of middleware which will prepend a zero if the value under validation is below 10 and higher than 0. This can be handy for dates i.e. validation of a month or day.

```php
use KrisKuiper\Validator\Blueprint\Contracts\MiddlewareFieldInterface;
use KrisKuiper\Validator\Blueprint\Middleware\Transforms\AbstractMiddleware;

class LeadingZeroMiddleware extends AbstractMiddleware
{
    public function handle(MiddlewareFieldInterface $field): void
    {
        $value = $field->getValue();

        if (is_numeric($value) === false) {
            return;
        }

        $value = (float) $value;

        if ($value < 10 && $value >= 0) {
            //Set the new value for the validation rules to work with
            $field->setValue('0' . $value);
        }
    }
}
```

Once the middleware has been defined, you may attach it to a validator by passing the namespace of the middleware object:

```php
$data = [
    'month' => 3
];

$validator = new Validator($data);

//Attach the custom middleware to the "month" field
$validator
    ->middleware('month')
    ->load(new LeadingZeroMiddleware());

//Attach the rules
$validator
    ->field('month')
    ->equals('03');

if($validator->passes()) {
    //Validation passes
}

//This will return ['month' => '03'] (mind the leading zero)
$validator->validatedData()->toArray();
```
*Note: Middleware is also attachable to [blueprint validators](#using-blueprints).*



## Using validation storage
You can store and retrieve arbitrary data within the validator after executing the validation. This can be useful when data is retrieved from a database to validate a custom rule, while the retrieved data is also needed outside of validation. 
This ensures that the database only needs to be requested once.

The validator has an `storage` object which you can use to `get()`, `set()` and `has()` methods.

##### Example 1: using rule closures
You can write your own custom [rule closures](#using-closures) that can use the validation storage:
```php
$data = ['product_id' => 123456];

$validator = new Validator($data);
$validator->field('product_id')->custom('existsInDB');

//Attach the custom rule
$validator->custom('existsInDB', function(Current $current) {
    
    //Store the product from the database in the validator storage object
    $product = $db->product->getById($current->getValue());
    $current->storage()->set('product', $product);
    
    return $product !== null;
});

$validator->execute();

//Check if the storage has the product
if($validator->storage()->has('product')) {

    //Retrieve the product
    $validator->storage()->get('product');
}
```

##### Example 2: using rule object
You can write your own custom [rule objects](#using-rule-objects) that can use the validation storage as well:
```php
$data = ['product_id' => 123456];

$validator = new Validator($data);

//You may also set new data for use in the custom rule object
$validator->storage()->set('foo', 'bar');

//Define the custom rule
$validator->loadRule(new CustomRule());

//Attach the custom rule
$validator->field('product_id')->custom(CustomStorageRule::RULE_NAME);

$validator->execute();
$validator->storage()->get('foo') //bar;
$validator->storage()->get('product') //Database product which was set within the rule object
```

And within the custom rule object (see [rule objects](#using-rule-objects) for more information):
```php
public function isValid(Current $current): bool
{
    //Check if the data exists 
    if(true === $current->storage()->has('foo')) {
        
        //Store the product from the database in the validator storage object
        $product = $db->product->getById($current->getValue());
        $current->storage()->set('product', $product);
        
        //Retrieve the data
        return 'bar' === $current->storage()->get('foo');
    }

    return false;
}
```



## Examples

##### Example 1: Validating registration form

```php
use KrisKuiper\Validator\Blueprint\Custom\Current;
use KrisKuiper\Validator\Error;
use KrisKuiper\Validator\Validator;

$data = [
    'name' => 'Morris',
    'email' => 'morris@email.com',
    'terms' => '1',
    'date_of_birth' => [
        'day' => '28',
        'month' => '3',
        'year' => '1952'
    ]
];

$validator = new Validator($data);

$validator
    ->combine('date_of_birth.year', 'date_of_birth.month', 'date_of_birth.day')
    ->glue('-')
    ->alias('date_of_birth');

$validator
    ->middleware('date_of_birth.month', 'date_of_birth.day')
    ->leadingZero();

$validator
    ->field('name')
    ->lengthBetween(2, 20)
    ->isString()
    ->required();

$validator
    ->field('email')
    ->lengthMax(40)
    ->email()
    ->required()
    ->custom('inDatabase')
    ->bail();

$validator
    ->field('terms')
    ->accepted();

$validator
    ->field('date_of_birth')
    ->date()
    ->after('1900-01-01')
    ->before(date('Y-m-d'));

$validator->custom('inDatabase', function(Current $current) {
    return $current->getValue() !== 'already exists in database code';
});

//Validation passes
if($validator->passes()) {
    print_r($validator->validatedData()->toArray());
}

//Validation fails
if($validator->fails()) {

    $validator->errors()->each(function(Error $error) {
        print_r($error->getMessage());
    });
}
```



##### Example 2: Password validation

```php
use KrisKuiper\Validator\Error;
use KrisKuiper\Validator\Validator;

$data = [
    'password' => 'very_strong_password',
    'password_repeat' => 'very_strong_password',
];

$validator = new Validator($data);

$validator
    ->field('password')
    ->required()
    ->isString()
    ->containsNumber()
    ->containsLetter()
    ->containsMixedCase()
    ->containsSymbol()
    ->lengthBetween(8, 50);

$validator
    ->field('password_repeat')
    ->same('password');

//Validation passes
if($validator->passes()) {
    print_r($validator->validatedData()->not('password_repeat')->toArray());
}

//Validation fails
if($validator->fails()) {

    $validator->errors()->each(function(Error $error) {
        print_r($error->getMessage());
    });
}
```



##### Example 3: Combining multiple date fields for single validation

```php
use KrisKuiper\Validator\Error;
use KrisKuiper\Validator\Validator;

$data = [
    'year' => '1952',
    'month' => '3',
    'day' => '28',
];

$validator = new Validator($data);

$validator
    ->combine('year', 'month', 'day')
    ->glue('-')
    ->alias('date');

$validator
    ->middleware('month', 'day')
    ->leadingZero();

$validator
    ->field('date')
    ->date();

//Validation passes
if($validator->passes()) {
    print_r($validator->validatedData()->toArray());
}

//Validation fails
if($validator->fails()) {

    $validator->errors()->each(function(Error $error) {
        print_r($error->getMessage());
    });
}
```



##### Example 4: Using blueprints

```php
use KrisKuiper\Validator\Blueprint\Blueprint;
use KrisKuiper\Validator\Error;
use KrisKuiper\Validator\Validator;

$data = [
    'name' => 'Morris',
    'role' => 'moderator',
    'email' => 'morris@email.com',
    'password' => 'very_strong_password',
    'password_repeat' => 'very_strong_password',
];

//Create blueprint
$blueprint = new Blueprint();

$blueprint
    ->field('name')
    ->isString()
    ->lengthBetween(2, 30)
    ->required();

$blueprint
    ->field('role')
    ->in(['admin', 'moderator', 'user'])
    ->required();

$blueprint
    ->field('email')
    ->email()
    ->lengthBetween(5, 50);


//Use the blueprint in the validator
$validator = new Validator($data);

$validator
    ->loadBlueprint($blueprint);

$validator
    ->field('password')
    ->required()
    ->lengthBetween(8, 50);

$validator
    ->field('password_repeat')
    ->same('password');

//Validation passes
if($validator->passes()) {
    print_r($validator->validatedData()->not('password_repeat')->toArray());
}

//Validation fails
if($validator->fails()) {

    $validator->errors()->each(function(Error $error) {
        print_r($error->getMessage());
    });
}
```


## License

Modern PHP Validator is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).