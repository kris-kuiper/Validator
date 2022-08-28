<?php

declare(strict_types=1);

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
