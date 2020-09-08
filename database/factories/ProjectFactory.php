<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Project;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'developer_name' => $faker->firstName,
        'app_name' => $faker->word,
        'version' => $faker->numberBetween(0,100),
        'logo' =>$faker->image('public/images',120,60, null, false),
        'about' => $faker->text,
    ];
});
