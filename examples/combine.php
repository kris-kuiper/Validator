<?php

declare(strict_types=1);

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
$validator->field('date')->date();

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
