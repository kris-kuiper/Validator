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
- 15+ predefined [middleware](#predefined-middleware) or [create your own](#custom-middleware) custom middleware;
- No new syntax you need to learn as in the case with i.e. Laravel Validator. Your editor/IDE can complete every validation rule, custom message, middleware, etc. out of the box;
- Easy [retrieving the validated data](#working-with-validated-data) after validation;
- [Combine](#combining-fields-for-validation) multiple fields as one for single validation (i.e. day, month, year inputs as a single date field for validation);
- Use validation [blueprints](#using-blueprints) to extend other validators for [DRY](https://en.wikipedia.org/wiki/Don%27t_repeat_yourself) method;
- Define you [own validation rules](#custom-validation-rules) and [custom error messages](#setting-custom-error-messages).

Modern PHP Validator provides several approaches to validate your application's (incoming) data. It makes it a breeze to validate form submit values as combining multiple input for single validation. It supports middleware and custom validation rules and error messages. It will also return the validated data to insert the data into i.e. a database.



All documentation can be found in the [docs](/docs) folder.

## Index

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
- [Filtering values based on validation rules](#filtering-values-based-on-validation-rules)
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
- [Validation events](#validation-events)
  - [Before event](#before-event)
  - [After event](#after-event)
- [Using validation storage](#using-validation-storage)
- [Examples](#examples)
  - [Validating registration form](#example-1-validating-registration-form)
  - [Password validation](#example-2-password-validation)
  - [Combining multiple date fields for single validation](#example-3-combining-multiple-date-fields-for-single-validation)
  - [Using blueprints](#example-4-using-blueprints)
- [License](#license)



















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
| [Contains number](#contains-number)         | [IP private](#ip-private)                 | [Negative or zero](#negative-or-zero) | [UUID v4](#uuid-v4)                           |
| [Contains symbol](#contains-symbol)         | [IP public](#ip-public)                   | [Not in](#not-in)                     | [UUID v5](#uuid-v5)                           |
| [Count](#count)                             | [IP v4](#ip-v4)                           | [Number](#number)                     | [Words](#words)                               |
| [Countable](#countable)                     | [IP v6](#ip-v6)                           | [Positive](#positive)                 | [Words max](#words-max)                       |
| [Count between](#count-between)             | [Is array](#is-array)                     | [Positive or zero](#positive-or-zero) | [Words min](#words-min)                       |
| [Count max](#count-max)                     | [Is bool](#is-boolean)                    | [Present](#present)                   |                                               |
| [Count min](#count-min)                     | [Is empty](#is-empty)                     | [Regex](#regex)                       |                                               |



































## License

Modern PHP Validator is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).