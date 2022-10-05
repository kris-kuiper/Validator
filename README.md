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

- 80+ predefined validation rules;
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
- Events
  - [Before event](/docs/14%20-%20Events/14.1%20-%20Before%20validation%20event.md)
  - [After event](/docs/14%20-%20Events/14.2%20-%20After%20validation%20event.md)
- Storage
  - [Storage](/docs/15%20-%20Storage/15.1%20-%20Validation%20storage.md)
- Examples
  - [Validating registration form](/docs/16%20-%20Examples/16.1%20-%20Validating%20registration%20form.md)
  - [Password validation](/docs/16%20-%20Examples/16.2%20-%20Password%20validation.md)
  - [Combining multiple date fields for single validation](/docs/16%20-%20Examples/16.3%20-%20Combining%20multiple%20date%20fields%20for%20single%20validation.md)
  - [Using blueprints](/docs/16%20-%20Examples/16.4%20-%20Using%20blueprints.md)
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
"kris-kuiper/validator": "^1.3"
```


## Validation rules
Below is a list with all predefined validation rules.

|                                             |                                           |                                       |                                               |
|---------------------------------------------|-------------------------------------------|---------------------------------------|-----------------------------------------------|
| [Accepted if](#accepted-if)                 | [Date](#date)                             | [Is false](#is-false)                 | [Required](#required)                         |
| [AcceptedNotEmpty](#accepted-not-empty)     | [Different](#different)                   | [Is int](#is-int)                     | [Required with](#required-with)               |
| [After](#after)                             | [Different with all](#different-with-all) | [Is not null](#is-not-null)           | [Required with all](#required-with-all)       |
| [After or equal](#after-or-equal)           | [Digits](#digits)                         | [Is null](#is-null)                   | [Required without](#required-without)         |
| [Alpha](#alpha)                             | [Digits between](#digits-between)         | [Is string](#is-string)               | [Required without all](#required-without-all) |
| [Alpha dash](#alpha-dash)                   | [Digits min](#digits-min)                 | [Is true](#is-true)                   | [Same](#same)                                 |
| [Alpha numeric](#alpha-numeric)             | [Distinct](#distinct)                     | [Json](#json)                         | [Scalar](#scalar)                             |
| [Before](#before)                           | [Divisible by](#divisible-by)             | [Length](#length)                     | [Starts not with](#starts-not-with)           |
| [Before or equal](#before-or-equal)         | [Email](#email)                           | [Length between](#length-between)     | [Starts with](#starts-with)                   |
| [Between](#between)                         | [Ends not with](#ends-not-with)           | [Length max](#length-max)             | [Time zone](#time-zone)                       |
| [Contains](#contains)                       | [Ends with](#ends-with)                   | [Length min](#length-min)             | [Url](#url)                                   |
| [Contains not](#contains-not)               | [Equals](#equals)                         | [Max](#max)                           | [UUID](#uuid)                                 |
| [Contains letter](#contains-letter)         | [In](#in)                                 | [Min](#min)                           | [UUID v1](#uuid-v1)                           |
| [Contains mixed case](#contains-mixed-case) | [IP](#ip)                                 | [Negative](#negative)                 | [UUID v3](#uuid-v3)                           |
| [Contains number](#contains-digit)          | [IP private](#ip-private)                 | [Negative or zero](#negative-or-zero) | [UUID v4](#uuid-v4)                           |
| [Contains symbol](#contains-symbol)         | [IP public](#ip-public)                   | [Not in](#not-in)                     | [UUID v5](#uuid-v5)                           |
| [Count](#count)                             | [IP v4](#ip-v4)                           | [Number](#number)                     | [Words](#words)                               |
| [Countable](#countable)                     | [IP v6](#ip-v6)                           | [Positive](#positive)                 | [Words max](#words-max)                       |
| [Count between](#count-between)             | [Is array](#is-array)                     | [Positive or zero](#positive-or-zero) | [Words min](#words-min)                       |
| [Count max](#count-max)                     | [Is bool](#is-boolean)                    | [Present](#present)                   |                                               |
| [Count min](#count-min)                     | [Is empty](#is-empty)                     | [Regex](#regex)                       |                                               |




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