<?php

use Faker\Generator as Faker;

$factory->define(\App\Capitulo::class, function (Faker $faker) {
    return [
        'obra_id' => $faker->numberBetween(1, 30),
        'titulo' => $faker->sentence,
        'texto' => $faker->text,
    ];
});
