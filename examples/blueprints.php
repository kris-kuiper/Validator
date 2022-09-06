<?php

declare(strict_types=1);

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
$blueprint->field('name')->required()->isString()->lengthBetween(2, 30);
$blueprint->field('role')->required()->in(['admin', 'moderator', 'user']);
$blueprint->field('email')->email()->lengthBetween(5, 50);

//Use the blueprint in the validator
$validator = new Validator($data);
$validator->loadBlueprint($blueprint);
$validator->field('password')->required()->lengthBetween(8, 50);
$validator->field('password_repeat')->same('password');

//Validation passes
if (true === $validator->passes()) {
    print_r($validator->validatedData()->not('password_repeat')->toArray());
}

//Validation fails
if (true === $validator->fails()) {
    $validator->errors()->each(function (Error $error) {
        print_r($error->getMessage());
    });
}
