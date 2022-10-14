Modern PHP Validator - Standalone Validation on Steroids
====================

![Modern PHP Validator](logo.png)

[![Latest Stable Version](http://poser.pugx.org/kris-kuiper/validator/v)](https://packagist.org/packages/kris-kuiper/validator)
[![License](http://poser.pugx.org/kris-kuiper/validator/license)](https://packagist.org/packages/kris-kuiper/validator)
[![PHP Version Require](http://poser.pugx.org/kris-kuiper/validator/require/php)](https://packagist.org/packages/kris-kuiper/validator)
[![codecov](https://codecov.io/gh/kris-kuiper/validator/branch/master/graph/badge.svg)](https://codecov.io/gh/kris-kuiper/validator)




## Introduction
Validating incoming data or array's (i.e. POST data) should not be hard. Meet Modern PHP Validator which does the trick nice, clean and easy.

Here are a couple of the many perks:

- 100+ predefined validation rules;
- 15+ predefined [middleware](/docs/13%20-%20Middleware/13.2%20-%20Predefined%20middleware.md) or [create your own](/docs/13%20-%20Middleware/13.3%20-%20Custom%20middleware.md) custom middleware;
- No new syntax you need to learn as in the case with i.e. Laravel Validator. Your editor/IDE can complete every validation rule, custom message, middleware, etc. out of the box;
- Easy [retrieving the validated data](/docs/10%20-%20Retrieving%20validated%20data/10.1%20-%20Returning%20only%20validated%20data.md) after validation;
- [Combine](/docs/08%20-%20Combining%20fields%20for%20single%20validation/8.1%20-%20Combining%20fields.md) multiple fields as one for single validation (i.e. day, month, year inputs as a single date field for validation);
- Use validation [blueprints](/docs/12%20-%20Validation%20blueprints/12.1%20-%20Using%20blueprints.md) to extend other validators for [DRY](https://en.wikipedia.org/wiki/Don%27t_repeat_yourself) method;
- Define you [own validation rules](/docs/05%20-%20Custom%20validation%20rules/5.2%20-%20Using%20closures.md) and [custom error messages](/docs/09%20-%20Errors%20messages/9.4%20-%20Custom%20error%20messages.md).

Modern PHP Validator provides several approaches to validate your application's (incoming) data. It makes it a breeze to validate form submit values as combining multiple input for single validation. It supports middleware and custom validation rules and error messages. It will also return the validated data to insert the data into i.e. a database.



## Documentation
All documentation can be found in the [docs](/docs) folder.

### Index:

- Intro
  - [Introduction](/docs/01%20-%20Intro/1.1%20-%20Introduction.md)
  - [Head first example](/docs/01%20-%20Intro/1.2%20-%20Head%20first%20example.md)
- Installation
  - [Installation](/docs/02%20-%20Installation/2.1%20-%20Installation.md)
- Execute validation
  - [Adding fields for validation](/docs/03%20-%20Execute%20validation/3.1%20-%20Adding%20fields%20for%20validation.md)
  - [Execute validation](/docs/03%20-%20Execute%20validation/3.2%20-%20Execute%20validation.md)
- Validation rules
  - [Special required rules](/docs/04%20-%20Validation%20rules/4.1%20-%20Special%20required%20rules.md)
  - [Rules](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md)
  - [Stopping on first validation rule failure](/docs/04%20-%20Validation%20rules/4.3%20-%20Stopping%20on%20first%20validation%20rule%20failure.md)
- Custom validation rules
  - [Using rule class objects](/docs/05%20-%20Custom%20validation%20rules/5.1%20-%20Using%20rule%20class%20objects.md)
  - [Using closures](/docs/05%20-%20Custom%20validation%20rules/5.2%20-%20Using%20closures.md)
- Conditional rules
  - [Conditionally adding rules](/docs/06%20-%20Conditional%20validation/6.1%20-%20Conditionally%20adding%20rules.md)
- Validation filtering
  - [Filtering values based on validation rules](/docs/07%20-%20Filtering%20values%20based%20on%20rules/7.1%20-%20Filtering%20values%20based%20on%20validation%20rules.md)
- Combining
  - [Combining fields for single validation](/docs/08%20-%20Combining%20fields%20for%20single%20validation/8.1%20-%20Combining%20fields.md)
- Errors messages
  - [Working with error messages](/docs/09%20-%20Errors%20messages/9.1%20-%20Working%20with%20error%20messages.md)
  - [Retrieving error messages](/docs/09%20-%20Errors%20messages/9.2%20-%20Retrieving%20error%20messages.md)
  - [Working with error objects](/docs/09%20-%20Errors%20messages/9.3%20-%20Working%20with%20error%20objects.md)
  - [Custom error messages](/docs/09%20-%20Errors%20messages/9.4%20-%20Custom%20error%20messages.md)
- Retrieving validated data
  - [Returning only validated data](/docs/10%20-%20Retrieving%20validated%20data/10.1%20-%20Returning%20only%20validated%20data.md)
  - [Filtering validated data](/docs/10%20-%20Retrieving%20validated%20data/10.2%20-%20Filtering%20validated%20data.md)
  - [Filter empty values](/docs/10%20-%20Retrieving%20validated%20data/10.3%20-%20Filter%20empty%20values.md)
- Aliases
  - [Field name aliases](/docs/11%20-%20Field%20name%20aliases/11.1%20-%20Aliases.md)
- Blueprints
  - [Validation blueprints](/docs/12%20-%20Validation%20blueprints/12.1%20-%20Using%20blueprints.md)
- Middleware
  - [Using middleware](/docs/13%20-%20Middleware/13.1%20-%20Using%20middleware.md)
  - [Predefined middleware](/docs/13%20-%20Middleware/13.2%20-%20Predefined%20middleware.md)
  - [Custom middleware](/docs/13%20-%20Middleware/13.3%20-%20Custom%20middleware.md)
- Default values
  - [Default values](/docs/14%20-%20Default%20values/14.1%20-%20Default%20values.md)
- Events
  - [Before event](/docs/15%20-%20Events/15.1%20-%20Before%20validation%20event.md)
  - [After event](/docs/15%20-%20Events/15.2%20-%20After%20validation%20event.md)
- Storage
  - [Storage](/docs/16%20-%20Storage/16.1%20-%20Validation%20storage.md)
- Examples
  - [Validating registration form](/docs/17%20-%20Examples/17.1%20-%20Validating%20registration%20form.md)
  - [Password validation](/docs/17%20-%20Examples/17.2%20-%20Password%20validation.md)
  - [Combining multiple date fields for single validation](/docs/17%20-%20Examples/17.3%20-%20Combining%20multiple%20date%20fields%20for%20single%20validation.md)
  - [Using blueprints](/docs/17%20-%20Examples/17.4%20-%20Using%20blueprints.md)
- License
  - [License](#license)




## Installation

Modern PHP Validator is available on Packagist (using semantic versioning). Installation via [Composer](https://getcomposer.org/) is the recommended way.

Run:
```shell script
composer require kris-kuiper/validator
```

Or add this line to your composer.json file:
```shell script
"kris-kuiper/validator": "^1.5"
```


## Validation rules
Below is a list with all predefined validation rules.



|                                                                                                 |                                                                                               |                                                                                           |                                                                                                   |
|-------------------------------------------------------------------------------------------------|-----------------------------------------------------------------------------------------------|-------------------------------------------------------------------------------------------|---------------------------------------------------------------------------------------------------|
| [Accepted](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#accepted)                       | [Date](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#date)                             | [Is bool](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#is-boolean)                | [Prohibited](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#prohibited)                     |
| [Accepted if](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#accepted-if)                 | [DateBetween](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#date-between)              | [Is empty](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#is-empty)                 | [Prohibited if](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#prohibited-if)               |
| [Accepted not empty](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#accepted-not-empty)   | [Declined](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#declined)                     | [Is false](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#is-false)                 | [Prohibits](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#prohibits)                       |
| [After (date)](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#after)                      | [Declined if](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#declined-if)               | [Is int](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#is-int)                     | [Regex](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#regex)                               |
| [After or equal (date)](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#after-or-equal)    | [Declined not empty](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#declined-not-empty) | [Is not null](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#is-not-null)           | [Required](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#required)                         |
| [Alpha](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#alpha)                             | [Different](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#different)                   | [Is null](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#is-null)                   | [Required with](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#required-with)               |
| [Alpha dash](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#alpha-dash)                   | [Different with all](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#different-with-all) | [Is string](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#is-string)               | [Required with all](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#required-with-all)       |
| [Alpha numeric](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#alpha-numeric)             | [Digits](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#digits)                         | [Is true](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#is-true)                   | [Required without](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#required-without)         |
| [Alpha space](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#alpha-space)                 | [Digits between](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#digits-between)         | [Json](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#json)                         | [Required without all](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#required-without-all) |
| [Before (date)](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#before)                    | [Digits max](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#digits-max)                 | [Length](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#length)                     | [Same](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#same)                                 |
| [Before or equal (date)](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#before-or-equal)  | [Digits min](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#digits-min)                 | [Length between](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#length-between)     | [Same not](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#same-not)                         |
| [Between](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#between)                         | [Distinct](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#distinct)                     | [Length max](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#length-max)             | [Scalar](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#scalar)                             |
| [CSS Color](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#css-color)                     | [Divisible by](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#divisible-by)             | [Length min](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#length-min)             | [Starts not with](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#starts-not-with)           |
| [Confirmed](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#confirmed)                     | [Email](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#email)                           | [Lowercase](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#lowercase)               | [Starts with](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#starts-with)                   |
| [Contains](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#contains)                       | [Ends not with](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#ends-not-with)           | [MAC address](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#mac-address)           | [Time zone](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#time-zone)                       |
| [Contains letter](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#contains-letter)         | [Ends with](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#ends-with)                   | [Max](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#max)                           | [Uppercase](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#uppercase)                       |
| [Contains mixed case](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#contains-mixed-case) | [Equals](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#equals)                         | [Min](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#min)                           | [URL](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#url)                                   |
| [Contains not](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#contains-not)               | [Hexadecimal](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#hexadecimal)               | [Negative](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#negative)                 | [UUID](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#uuid)                                 |
| [Contains number](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#contains-digit)          | [In](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#in)                                 | [Negative or zero](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#negative-or-zero) | [UUID v1](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#uuid-v1)                           |
| [Contains symbol](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#contains-symbol)         | [IP](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#ip)                                 | [Not in](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#not-in)                     | [UUID v3](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#uuid-v3)                           |
| [Count (array)](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#count)                     | [IP private](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#ip-private)                 | [Nullable](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#nullable)                 | [UUID v4](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#uuid-v4)                           |
| [Countable (array)](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#countable)             | [IP public](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#ip-public)                   | [Number](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#number)                     | [UUID v5](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#uuid-v5)                           |
| [Count between (array)](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#count-between)     | [IP v4](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#ip-v4)                           | [Positive](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#positive)                 | [Words](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#words)                               |
| [Count max (array)](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#count-max)             | [IP v6](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#ip-v6)                           | [Positive or zero](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#positive-or-zero) | [Words max](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#words-max)                       |
| [Count min (array)](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#count-min)             | [Is array](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#is-array)                     | [Present](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#present)                   | [Words min](/docs/04%20-%20Validation%20rules/4.2%20-%20Rules.md#words-min)                       |


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

And this is just the beginning... Check out the [docs](/docs) for lots of more validation goodies.



## License

Modern PHP Validator is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).