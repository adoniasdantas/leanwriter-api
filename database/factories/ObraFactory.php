<?php

use Faker\Generator as Faker;

$factory->define(\App\Obra::class, function (Faker $faker) {
    return [
        'titulo' => $faker->sentence,
        'descricao' => $faker->text(200),
        'user_id' => $faker->numberBetween(1, 15),
    ];
});
