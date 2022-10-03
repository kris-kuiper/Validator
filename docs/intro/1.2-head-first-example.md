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