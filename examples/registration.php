<?php

declare(strict_types=1);

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
$validator->field('email')->lengthMax(40)->email()->required()->custom('inDatabase')->bail();
$validator->field('terms')->accepted();
$validator->field('date_of_birth')->date()->after('1900-01-01')->before(date('Y-m-d'));
$validator->custom('inDatabase', function (Current $callback) {
    return 'already exists in database code' !== $callback->getValue();
});

//Validation passes
if (true === $validator->passes()) {
    print_r($validator->validatedData()->toArray());
}

//Validation fails
if (true === $validator->fails()) {
    $validator->errors()->each(function (Error $error) {
        print_r($error->getMessage());
    });
}
