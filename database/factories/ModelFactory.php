<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Common\Message::class, function (Faker\Generator $faker) {
    $id = $faker->uuid;
    $messageBody = [
        'uuid' => $id,
        'message' => $faker->realText($maxNbChars = 150, $indexSize = 1),
        'createdAt' => $faker->iso8601('now')
    ];

    return [
        'Id' => (string)$id,
        'MessageBody' => json_encode($messageBody)
    ];
});