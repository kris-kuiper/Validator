# Modern PHP validator

- [Introduction](#introduction)
- [Installation](#installation)
- [Adding fields for validation](#adding-fields-for-validation)
- [Execute validation](#execute-validation)
  - [Execute, fails and passes](#execute-fails-and-passes)
  - [Reset validation](#reset-validation)
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
- [Returning the validated data](#returning-the-validated-data)
  - [Returning only validated data](#returning-only-validated-data)
  - [Filter validated data](#filter-validated-data)
- [Using Blueprints](#using-blueprints)
- [Using middleware](#using-middleware)
  - [Predefined middleware](#predefined-middleware)
  - [Custom middleware](#custom-middleware)
- [Examples](#examples)
  - [Validating registration form](#example-1-validating-registration-form)
  - [Password validation](#example-2-password-validation)
  - [Combining multiple date fields for single validation](#example-3-combining-multiple-date-fields-for-single-validation)
  - [Using blueprints](#example-4-using-blueprints)




## Introduction
Validating incoming data or array's should not be hard. Meet Modern PHP validator which does the trick nice, clean and easy.

Here are a couple of the many perks of the validator:

- 65+ predefined validation rules;
- No new syntax you need to learn as in the case with i.e. Laravel Validator. Your editor/IDE can complete every validation rule, custom message, middleware, etc. out of the box.
- Easy retrieving the validated data after validation;
- Use pre-defined middleware or create your own;
- Combine multiple fields as one for single validation (i.e. day, month, year inputs as a single date field for validation);
- Use validation blueprints to extend other validators for [DRY](https://en.wikipedia.org/wiki/Don%27t_repeat_yourself) method;
- Define you own validation rules and custom error messages.



The validator provides several approaches to validate your application's (incoming) data. It makes it a breeze to validate form submit values as combining multiple input for single validation. It supports middleware and custom validation rules and error messages. It will also returns the validated data to insert the data into i.e. a database.

Let's dive directly into an example:

```php
$data = [
	'programmers' => [
		'name' => 'Morris',
		'email' => 'morris@domain.com'
	],
	'developers' => [
		'name' => 'Smith',
		'email' => 'smith@domain.com'
	],
    'department' => 'office',
    'color' => 'black'
];

$validator = new Validator($data);

//Select every age field
$validator->field('*.age')->required()->email();

//Select department and color field
$validator->field('department', 'color')->required(false)->isString()->lengthBetween(5, 20);

if($validator->passes()) {
    //Validation passes
}
```

And this is just the beginning...



## Installation

Modern PHP Validator is available on Packagist (using semantic versioning). Installation via [Composer](https://getcomposer.org/) is the recommended way.

Just add this line to your composer.json file:
```shell script
"kris-kuiper/validator": "^1.0"
```

or run:
```shell script
composer require kris-kuiper/validator
```




## Adding fields for validation

By using the `field` method, you can add one or more field names for validation.

##### Example

```php
use KrisKuiper\Validator\Validator;

$input = ['username' => '', 'password' => '', 'email' =>> ''];

$validator = new Validator($input);

//You can add a single field name
$validator->field('username')->required();

//Or add multiple field names
$validator->field('username', 'password', 'email')->required();
```



## Execute validation

#### Execute, fails and passes

The validator comes with an arsenal of built-in validation rules. To execute validation, you may use the `execute()`, `fails()` or `passes()` method.

```php
$validator->field('username')->minLength(5)->maxLength(20);

$passes = $validator->execute(); //Returns bool false/true

if(true === $validator->fails()) {
    //Validation fails
}

if(true === $validator->passes()) {
    //Validation success
}
```

The validator will only run once to avoid i.e. multiple database lookups when executing the `execute()`, `fails()` or `passes()` methods.



#### Revalidate validation

By default, the validator caches the validation result. So if you run the same validator again, the validator won't run all the rules, middleware, etc. It will directly return the result of the previous run.

To run the validator with all rules, middleware, etc. again, you can use the `revalidate()` method.

#####  Example:

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
$validator->field('email.*')->isEmail(); //Each value should be a valid email address
```



## Special "required" rules

Before explaining all the rules, you need to know the existence of the special "required" rules. These rules are special because they can disable (bail) other rules based on if the input is empty or not.

A field is considered "empty" if one of the following conditions are true:

- The value is `null`.
- The value is an empty `string`.
- The value is an empty `array` or empty `countable` object.



#### Required

The field under validation must be present in the input data and not empty.

In this example, the `minLength()` rule will not be executed, because the `required()` method prevents the `minLength` rule to be executed, due to the fact that the surname is considered `empty`.



##### Example 1:

```php
$data = ['surname' => ''];
$validator = new Validator($data);
$valdiator->field('surname')->required()->minLength(5);
```

*Note: validation will fail in this example, because the surname is required, but not provided*.



##### Example 2:

This validation will pass because the surname is only checked with the `minLength` rule when the field is not empty (which it is):

```php
$data = ['surname' => ''];
$validator = new Validator($data);
$valdiator->field('surname')->required(false)->minLength(5);
```



#### Required with

The field under validation must be present and not empty *only if* any of the other specified fields are present and not empty.

```php
$data = [
    'surname' => '', 
    'middlename' => 'Elizabeth', 
    'lastname' => 'Morris'
];

$validator = new Validator($data);
$valdiator->field('surname')->requiredWith('middlename', 'lastname');
```

*Note: validation will fail in this example, because the surname is required, but not provided*.



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
$validator->field('fieldname')->bail()->min(1)->max(5);
```

This will prevent that the `max` rule is executed if the `min` rule fails validation.



The order of the `bail` method does not matter. The example below will have the same result as the example above:

```php
$validator->field('fieldname')->min(1)->max(5)->bail();
```



## Validation rules

Below is a list with all predefined validation rules.

|                                             |                                   |                                               |
| ------------------------------------------- | --------------------------------- | --------------------------------------------- |
| [Accepted not empty](#accepted-not-empty)   | [Is array](#is-array)             | [Is UUID v3](#is-uuid-v3)                     |
| [After (date)](#after)                      | [Is boolean](#is-boolean)         | [Is UUID v4](#is-uuid-v4)                     |
| [Before (date)](#before)                    | [Is countable](#is-countable)     | [Is UUID v5](#is-uuid-v5)                     |
| [Between](#between)                         | [Is date](#is-date)               | [Length](#length)                             |
| [Contains](#contains)                       | [Is email](#is-email)             | [Length between](#length-between)             |
| [Contains letter](#contains-letter)         | [Is empty](#is-empty)             | [Max](#max)                                   |
| [Contains mixed case](#contains-mixed-case) | [Is false](#is-false)             | [Max length](#max-length)                     |
| [Contains number](#contains-number)         | [Is IP](#is-ip)                   | [Max words](#max-words)                       |
| [Contains symbol](#contains-symbol)         | [Is IP Private](#is-ip-private)   | [Min](#min)                                   |
| [Count](#count)                             | [Is IP Public](#is-ip-public)     | [Min length](#min-length)                     |
| [Count between](#count-between)             | [Is IP v4](#is-ip-v4)             | [Min words](#min-words)                       |
| [Count max](#count-max)                     | [Is IP v6](#is-ip-v6)             | [Not contains](#not-contains)                 |
| [Count min](#count-min)                     | [Is int](#is-int)                 | [Not In](#not-in)                             |
| [Different](#different)                     | [Is JSON](#is-json)               | [Present](#present)                           |
| [Different with all](#different-with-all)   | [Is MAC address](#is-mac-address) | [Regex](#regex)                               |
| [Distinct](#distinct)                       | [Is null](#is-null)               | [Required](#required)                         |
| [Ends not with](#ends-not-with)             | [Is number](#is-number)           | [Required with](#required-with)               |
| [Ends with](#ends-with)                     | [Is scalar](#is-scalar)           | [Required with all](#required-with-all)       |
| [Equals](#equals)                           | [Is string](#is-string)           | [Required without](#required-without)         |
| [In](#in)                                   | [Is timezone](#is-timezone)       | [Required without all](#required-without-all) |
| [Is accepted](#is-accepted)                 | [Is true](#is-true)               | [Same](#same)                                 |
| [Is alpha](#is-alpha)                       | [Is URL](#is-url)                 | [Starts not with](#starts-not-with)           |
| [Is alpha dash](#is-alpha-dash)             | [Is UUID](#is-uuid-v1)            | [Starts with](#starts-with)                   |
| [Is alpha numeric](#is-alpha-numeric)       | [Is UUID v1](#is-uuid-v1)         | [Words](#words)                               |



##### Accepted not empty

The field under validation must be "yes", "on", "1", "true", `1`, or `true` if another field's value is not empty.

```php
$data = ['field' => 'yes', 'other_field' => 'foo'];
$validator = new Validator($data);

$valdiator->field('fieldName')->acceptedNotEmpty('other_field');
```

You may also provide the values which should be considered as accepted:
```php
$valdiator->field('fieldName')->acceptedNotEmpty('other_field', ['accepted', 'agreed', 'checked']);
```

See also the [Is accepted](#is-accepted) rule.



##### After

Checks if the data under validation comes after a given date.

```php
$valdiator->field('fieldName')->after('2000-01-01', 'Y-m-d');
```
See also the [Before](#before) rule.



##### Before

Checks if the data under validation comes before a given date.

```php
$valdiator->field('fieldName')->before('2030-01-01', 'Y-m-d');
```
See also the [After](#after) rule.



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



##### Distinct

Check if all the values in an array are unique

```php
$valdiator->field('fieldName')->distinct();
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

See also the [Ends with](#ends-with), [Starts with](#starts-with) and [Starts not with](#starts-not-with) rule.



##### Ends with

Checks if the data under validation ends with a given value.

```php
$valdiator->field('fieldName')->endsWith('abc');
```

Use the second parameter to match case-sensitive:
```php
$valdiator->field('fieldName')->endsWith('ABC', true);
```

See also the [Ends not with](#ends-not-with), [Starts with](#starts-with) and [Starts not with](#starts-not-with) rule.



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

See also the [not in](#not-in) rule.



##### Is array

Checks if the data under validation is an array.

```php
$valdiator->field('fieldName')->isArray();
```



##### Is accepted

Checks if the data under validation is accepted. By default, the field under validation must be *yes*, *on*, *1*, or *true*. This is useful for validating "Terms of Service" acceptance.

```php
$valdiator->field('fieldName')->isAccepted();
```

You may also pass an array with values which are considered accepted:
```php
$valdiator->field('fieldName')->isAccepted(['accept', 'agree', 'ok']);
```



##### Is alpha

Checks if the field under validation only contains alpha characters (a-z and A-Z).

```php
$valdiator->field('fieldName')->isAlpha();
```



##### Is alpha dash

Checks if the field under validation only contains letters and numbers, dashes and underscores.

```php
$valdiator->field('fieldName')->isAlphaDash();
```



##### Is alpha numeric

Checks if the field under validation only exists off letters and numbers.

```php
$valdiator->field('fieldName')->isAlphaNumeric();
```



##### Is boolean

Checks if the data under validation is a boolean.

```php
$valdiator->field('fieldName')->isBool();
```



##### Is countable

Checks if the data under validation is countable.

```php
$valdiator->field('fieldName')->isCountable();
```



##### Is date

Checks if the data under validation is a valid date.

```php
$valdiator->field('fieldName')->isDate('Y-m-d');
```



##### Is email

Checks if the data under validation is a valid email address.

```php
$valdiator->field('fieldName')->isEmail();
```



##### Is empty

Checks if the data under validation is empty. Empty string, empty array and null are considered empty.

```php
$valdiator->field('fieldName')->isEmpty();
```



##### Is false

Checks if the data under validation is boolean false.

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



##### Is IP

Checks if the data under validation is a valid IP address (v4 or v6).

```php
$valdiator->field('fieldName')->isIP();
```



##### Is IP private 

Checks if the data under validation is a private IP address (v4 or v6).

```php
$valdiator->field('fieldName')->isIPPrivate();
```



##### Is IP public 

Checks if the data under validation is a public ip address (v4 or v6).

```php
$valdiator->field('fieldName')->isIPPublic();
```



##### Is IP V4

Checks if the data under validation is a valid IP V4 address.

```php
$valdiator->field('fieldName')->isIPV4();
```



##### Is IP V6

Checks if the data under validation is a valid IP V6 address.

```php
$valdiator->field('fieldName')->isIPV6();
```



##### Is JSON

Checks if the data under validation is valid JSON.

```php
$valdiator->field('fieldName')->isJSON();
```



##### Is MAC address

Checks if the data under validation is a valid MAC address. By default, the dash "-" symbol is used as the delimiter for a valid MAC address.

```php
$valdiator->field('fieldName')->isMACAddress();
```

You can change the delimiter i.e. colon:
```php
$valdiator->field('fieldName')->isMACAddress(':');
```



##### Is not NULL

Checks if the data under validation is not NULL.

```php
$valdiator->field('fieldName')->isNotNull();
```
See also the [Is null](#is-null) rule.



##### Is NULL

Checks if the data under validation is NULL.

```php
$valdiator->field('fieldName')->isNull();
```
See also the [Is not null](#is-not-null) rule.


##### Is number

Checks if the data under validation is an integer number.

```php
$valdiator->field('fieldName')->isNumber();
```

You can use the strict parameter to strictly check if a value is a number:
```php
$valdiator->field('fieldName')->isNumber(true);
```



##### Is scalar

Checks if the data under validation is a scalar type.

```php
$valdiator->field('fieldName')->isScalar();
```



##### Is string

Checks if the data under validation is of the type string.

```php
$valdiator->field('fieldName')->isString();
```



##### Is timezone

Checks if the data under validation is a valid timezone.

```php
$valdiator->field('fieldName')->isTimezone();
```

Use the first parameter to search case-insensitive:
```php
$valdiator->field('fieldName')->isTimezone(true);
```


*Note: see [timezones](https://www.php.net/manual/en/datetimezone.listidentifiers.php) on php.net for more information.*


##### Is true

Checks if value equals boolean true.

```php
$valdiator->field('fieldName')->isTrue();
```



##### Is URL

Checks if the data under validation is a valid URL. By default, the protocol will not be checked.

```php
$valdiator->field('fieldName')->isURL();
```

Force the protocol (i.e. http or https):
```php
$valdiator->field('fieldName')->isURL(true);
```



##### Is UUID

Checks if the data under validation is a valid UUID v1, v3, v4 or v5 entity.

```php
$valdiator->field('fieldName')->isUUID();
```



##### Is UUID v1

Checks if the data under validation is a valid UUID v1 entity.

```php
$valdiator->field('fieldName')->isUUIDv1();
```



##### Is UUID v3

Checks if the data under validation is a valid UUID v3 entity.

```php
$valdiator->field('fieldName')->isUUIDv3();
```



##### Is UUID v4

Checks if the data under validation is a valid UUID v4 entity.

```php
$valdiator->field('fieldName')->isUUIDv4();
```



##### Is UUID v5

Checks if the data under validation is a valid UUID v4 entity.

```php
$valdiator->field('fieldName')->isUUIDv5();
```



##### Length

Checks if the value character length is the given length.

```php
$valdiator->field('fieldName')->length(int $characters);
```



##### Length between

Checks if the data under validation is a valid URL.

```php
$valdiator->field('fieldName')->lengthBetween(int $minimum, int $maximum);
```



##### Max

Checks if the value is less than the given maximum amount.

```php
$valdiator->field('fieldName')->max(10.5);
```



##### Max length

Checks if the amount of characters is less or equal than the given amount.

```php
$valdiator->field('fieldName')->maxLength(10);
```



##### Max words

Checks if the amount of words is less than or equal to a given amount. By default, a word is defined to have two or more alphanumeric characters.

```php
$valdiator->field('fieldName')->maxWords(10);
```

The second parameter defines the minimum length of the word, while the third parameter can be used to allow all symbols instead of only alphanumeric characters:
```php
$valdiator->field('fieldName')->maxWords(10, 5, false);
```



##### Min

Checks if the field under validation is at least a given minimum.

```php
$valdiator->field('fieldName')->min(10.5;
```



##### Min length

Checks if the amount of characters is at least a given amount.

```php
$valdiator->field('fieldName')->minLength(5);
```



##### Min words

Checks if the amount of words is more than or equal to a given amount. By default, a word is defined to have two or more alphanumeric characters.

```php
$valdiator->field('fieldName')->minWords(10);
```

The second parameter defines the minimum length of the word, while the third parameter can be used to allow all symbols instead of only alphanumeric characters:
```php
$valdiator->field('fieldName')->minWords(10, 5, false);
```



##### Not contains

Checks if the data under validation does not contain a given value.

```php
$valdiator->field('fieldName')->notContains($value, bool $caseSensitive = false);
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



##### Starts not with

Checks if the data under validation does not begin with a given value.

```php
$valdiator->field('fieldName')->startsNotWith('abc');
```

Use the second parameter to search case-sensitive:
```php
$valdiator->field('fieldName')->startsNotWith('ABC', true);
```

See also the [Starts with](#starts-with), [Ends with](#ends-with) and [Ends not with](#ends-not-with) rule.



##### Starts with

Checks if the data under validation begins with a given value.

```php
$valdiator->field('fieldName')->startsWith('abc');
```

Use the second parameter to search case-sensitive:
```php
$valdiator->field('fieldName')->startsWith('ABC', true);
```

See also the [Ends with](#ends-with), [Ends not with](#ends-not-with) and [Starts not with](#starts-not-with) rule.



##### Words

Checks if the amount of words is at least a given amount.

```php
$valdiator->field('fieldName')->words(int $words, int $minCharacters = 2, bool $onlyAlphanumeric = true);
```

See also the [Max words](#max-words) and [Min words](#min-words) rules.



## Custom validation rules

#### Using rule objects

Although there is a large number of validation rules, you may wish to specify some of your own. One method of registering custom validation rules is using rule objects.

Below is a blueprint/example of a custom rule:

```php
<?php
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



Once the rule has been defined, you may attach it to a validator by  passing the namespace of the rule object with your other validation rules:

```php
use KrisKuiper\Validator\Validator;

$data = ['name' => 'Morris'];
$validator = new Validator($data);

//Attach the custom rule
$validator->loadRule(new CustomRule());

//Use the custom rule
$validator->field('name')->custom(CustomRule::RULE_NAME, ['min' => 5]); 

//Set a optional custom error message
$validator
    ->messages('name')
    ->custom('length', 'Invalid value, at least :min characters'); 

if($validator->passes()) {
 	//Validation passes   
}
```



*Note 1: The name `length` equals the output of the `getName()` method from the rule object.*

*Note 2: The error message will be used from the `getMessage()` method from the rule object, unless you set an optional custom error message like in the example above.*



#### Using closures

If you only need the functionality of a custom rule once throughout your application, you may use a closure instead of a rule object.

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
$validator->field('name')->custom('length', ['min' => 5]);

//Set the error message
$validator->messages('name')->custom('length', 'Invalid value, at least :min characters');

if($validator->passes()) {
 	//Validation passes   
}
```



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
	    return $current->getValue('amount') > 99;
	})
    ->required()
    ->maxLength(2000);

$validator->execute());
```

In this example, the validation will fail because the amount is higher than 99, so the reason field is required.

If the amount is below 100, validation will pass.


#### Using multiple conditions

Although the last rule `isString` in example below is requires the provided data to be a `string` and the provided age is an `interger` number, the validation still succeeds. This is because the last `conditional` rule returns `false`, so the `isString` rule is not executed.

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
        return false; //This will prevent executing the isString() rule
    })
    ->isString();

$validator->execute(); //Returns true
```





## Combining fields for validation

Sometimes you need to check multiple input values as one value i.e. day, month and year into a single date field or a serial code separated into four blocks. Modern PHP Validator lets you combine them into a new value for validation using the `glue` or `format` method described below.

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
$validator->combine('year', 'month', 'day')->glue('-')->alias('date'); //1952-28-03
$validator->field('date')->isdate('Y-m-d');
```



#### Combining with the format method

You can also combine multiple fields with the `format()` method for more control:

```php
$input = ['year' => '1952', 'month' => '28', 'day' => '03'];

$validator = new Validator($input);
$validator->combine('year', 'month', 'day')->format(':year/:month/:day')->name('date'); //1952/28/03
$validator->field('date')->isdate('Y/m/d');
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

The errors()` method can be used to retrieve a collection of all the errors, optional filtered on a specific field. If the field name parameters is provided, it will return all the errors for this specific field.

Imagine the following validation data and rules:

```php
$data = ['username' => 'abc', 'password' => '', 'password_repeat'];

$validator = new Validator($data);
$validator->field('username')->between(5, 10)->startsWith('def');
$validator->field('password')->same('password_repeat');
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



You can also get all first errors for every unique field name using the `distinct` method:

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

We now have a single error object. This object has several handy methods:



##### Return the error message

Returns the parsed (with variable parameters) error message.

```php
$error->getMessage();
```

This will return

```
Value should be between 5 and 10 characters long
```



##### Return the unparsed error message

Returns the raw (without variable parameters) error message.

```php
$error->getRawMessage();
```

This will return

```
Value should be between :minimum and :maximum characters long
```



##### Return the field name

Returns the name of the field that has been validated.

```php
$error->getFieldName();
```

This will return

```
username
```



##### Return the value of the field

Returns the value that has been validated which causes the error to trigger.

```php
$error->getValue();
```

This will return

```
abc
```



##### Return the parameters of the rule

Returns the parameters used for validation.

```php
$error->getParameters();
```

This will return

```php
['minimum' => 5, 'maximum' => 10]
```



##### Return the rule name

Returns the name of the rule used for validation.

```php
$error->getRuleName();
```

This will return

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
$validator->field('amount', 'product')->required();

//Set error message globally for the required rule
$validator->messages()->required('Field is required!'); 
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
$validator->messages('amount')->required('Amount is required!'); 

//Sets the required error messages specific for the product field
$validator->messages('product')->required('Product is required!'); 
```



##### Example 3: Combination of globally and per field and rule error messages

```php
$data = [
    'amount' => 4,
    'product' => 'Laptop'
];

$validator = new Validator($data);
$validator->field('amount', 'product')->required();

//Sets the required error messages specific for the amount field
$validator->messages('amount')->required('Amount is required'); 

//Set error message globally for the required rule. This will only affect the product field in this example.
$validator->messages()->required('Field is required'); 
```



##### Example 4: Using variables in error messages

You can use the parameters name of the rule as placeholders. For example, the between rule, has two parameters named `$minimum` and `$maximum`. The placeholders will be replaced with their corresponding parameter values.
```php
$data = [
    'amount' => 4,
    'product' => 'Laptop'
];

$validator = new Validator($data);
$validator->field('amount')->between(1, 5); //$minimum and $maximum parameters

$validator->messages('amount')->between('Amount should be between :minimum and :maximum'); //Amount should be between 1 and 5'
```



## Returning the validated data

#### Returning only validated data

After validation, you can retrieve the data that has been validated. This is different from the given data, because it will only return the data where validation rules were applied.

```php
$data = [
    'username' => 'Morris', 
    'password' => '123'
];

$validator = new Validator($data);
$validator->field('username')->minLength(3)->maxLength(10)->isString();
$validator->execute(); //Without executing, there is no validated data
$validator->validatedData()->toArray(); //Array('username' => 'Morris')
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
$validator->field('username', 'email', 'password', 'interest.*.title')->required();
$validator->execute();
```



##### Include field names

```php
$validator->validatedData()->only('username', 'email')->toArray();
```

This will return:

```php
[
    'username' => 'Morris', 
    'email' => 'email@domain.com'
];
```



##### Exclude field names

```php
$validator->validatedData()->not('username', 'email', 'interest')->toArray();
```

This will return:

```php
['password' => '123'];
```



##### Extract multiple columns in key-pair value

```php
$validator->validatedData()->pluck('interest.*.title')->toArray();
```

This will return:

```php
['programming', 'coding']
```





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
$validator->loadBlueprint($blueprint); //Use the blueprint in the validator
$validator->field('email')->isEmail()->lengthBetween(5, 50); //Add extra rules that extend the blueprint

if(true === $validator->passes()) {
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
$blueprint->field('name')->lengthBetween(2, 30)->required();

//Define custom error messages
$blueprint
    ->message('name')
    ->required('The name field is required!')
    ->lengthBetween('The name should be between :minimum and :maximum characters long!');

//Define middleware
$blueprint->middleware('name')->trim();

//Define a custom rule
$blueprint->custom('morrisRule', function (Current $current) {
    return $current->getValue() === 'Morris';
});
```



Then use the blueprint in your validator:

```php
$data = ['name' => 'Morris', 'email' => 'morris@domain.com'];

$validator = new Validator($data);
$validator->loadBlueprint($blueprint); //Use the blueprint in the validator
$validator->field('email')->isEmail()->lengthBetween(5, 50); //Add extra rules that extend the blueprint

if(true === $validator->passes()) {
    //Validation passes
}
```



## Using middleware

Middleware provides a convenient mechanism to alter the input data before validation. You can trim all whitespace or add a leading zero to date inputs etc. Modern PHP Validator comes with predefined middleware which you can use, or you can create your [own custom middleware](#custom-middleware).

*Note: When retrieving the validated data with the `validatedData()` method, the altered values by the executed middleware will be returned.*

### Predefined middleware

Modern PHP Validator comes with predefined middleware which you can use.



##### Example 1:

In this example

```php
$data = [
    'emails' => [
	    '  MORRIS@domain.com    ',
	    ' Smith@domain.com '
    ]
];

$validator = new Validator($data);
$validator->field('emails.*')->isEmail()->lengthBetween(5, 50);

//Use the to lowercase and trim middleware
$validator
    ->middleware('emails.*')
    ->toLowercase()
    ->trim(); 

if(true === $validator->passes()) {
    
    $validator->validatedData()->toArray();
    /*
    [
    	'emails' => [
	    	'morris@domain.com',
		    'smith@domain.com'
    	]
    ]
    */
}
```



#### Middleware types:

Below is a list of all the predefined middleware. If

##### ABS

Converts numbers to their absolute value.

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
$valdiator->middleware('field')->ltrim('-*'); //Trims all the - and * characters
```

See also the [Trim](#trim) and the [Rtrim](#rtrim) middleware.



##### Replace

Replaces all occurrences of the search string with the replacement string.

```php
$valdiator->middleware('field')->replace('hello', 'hi'); //Replaces all "hello" with "hi"
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
$valdiator->middleware('field')->trim('-|*'); //Trims all the -, | and * characters
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
<?php
use KrisKuiper\Validator\Blueprint\Contracts\MiddlewareFieldInterface;
use KrisKuiper\Validator\Blueprint\Middleware\Transforms\AbstractMiddleware;

class LeadingZeroMiddleware extends AbstractMiddleware
{
    public function handle(MiddlewareFieldInterface $field): void
    {
        $value = $field->getValue();

        if (false === is_numeric($value)) {
            return;
        }

        $value = (float) $value;

        if ($value < 10 && $value >= 0) {
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
$validator->middleware('month')->load(new LeadingZeroMiddleware());
$validator->field('month')->equals('03');

if($validator->passes()) {
    //Validation passes
}

//['month' => '03']
$validator->validatedData()->toArray();
```



*Note: Middleware is also attachable to [blueprint validators](#using-blueprints)*



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
$validator->combine('date_of_birth.year', 'date_of_birth.month', 'date_of_birth.day')->glue('-')->alias('date_of_birth');
$validator->middleware('date_of_birth.month', 'date_of_birth.day')->leadingZero();
$validator->field('name')->lengthBetween(2, 20)->isString()->required();
$validator->field('email')->maxLength(40)->isEmail()->required()->custom('inDatabase')->bail();
$validator->field('terms')->isAccepted();
$validator->field('date_of_birth')->isDate()->after('1900-01-01')->before(date('Y-m-d'));
$validator->custom('inDatabase', function(Current $current) {
    return $current->getValue() !== 'already exists in database code';
});

//Validation passes
if(true === $validator->passes()) {
    print_r($validator->validatedData()->toArray());
}

//Validation fails
if(true === $validator->fails()) {

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
$validator->field('password')->required()->isString()->containsNumber()->containsLetter()->containsMixedCase()->containsSymbol()->lengthBetween(8, 50);
$validator->field('password_repeat')->same('password');

//Validation passes
if(true === $validator->passes()) {
    print_r($validator->validatedData()->not('password_repeat')->toArray());
}

//Validation fails
if(true === $validator->fails()) {

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
$validator->combine('year', 'month', 'day')->glue('-')->alias('date');
$validator->middleware('month', 'day')->leadingZero();
$validator->field('date')->isDate();

//Validation passes
if(true === $validator->passes()) {
    print_r($validator->validatedData()->toArray());
}

//Validation fails
if(true === $validator->fails()) {

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
$blueprint->field('name')->isString()->lengthBetween(2, 30)->required();
$blueprint->field('role')->in(['admin', 'moderator', 'user'])->required();
$blueprint->field('email')->isEmail()->lengthBetween(5, 50);

//Use the blueprint in the validator
$validator = new Validator($data);
$validator->loadBlueprint($blueprint);
$validator->field('password')->required()->lengthBetween(8, 50);
$validator->field('password_repeat')->same('password');

//Validation passes
if(true === $validator->passes()) {
    print_r($validator->validatedData()->not('password_repeat')->toArray());
}

//Validation fails
if(true === $validator->fails()) {

    $validator->errors()->each(function(Error $error) {
        print_r($error->getMessage());
    });
}
```