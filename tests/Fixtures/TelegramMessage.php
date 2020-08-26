<?php

// Wrap in function in order to keep global scope clean of variables
return (function(): array
{
    $faker = app(\Faker\Generator::class);
    $id = $faker->numberBetween(1, 9999);
    $firstName = $faker->firstName;
    $lastName = $faker->lastName;

    return [
        'update_id' => $faker->randomNumber(6),
        'message' =>
            [
                'message_id' => $faker->numberBetween(1, 200),
                'from' =>
                    [
                        'id' => $id,
                        'is_bot' => false,
                        'first_name' => $firstName,
                        'last_name' => $lastName,
                        'language_code' => $faker->languageCode,
                    ],
                'chat' =>
                    [
                        'id' => $id,
                        'first_name' => $firstName,
                        'last_name' => $lastName,
                        'type' => 'private',
                    ],
                'date' => time(),
                'text' => $faker->text(50),
            ],
    ];
})(); // self-calling closure
