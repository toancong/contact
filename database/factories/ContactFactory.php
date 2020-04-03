<?php

use Faker\Generator as Faker;

$factory->define(\Bean\Contact\Models\Contact::class, function (Faker $faker) {
    return [
        'object_type' => 'App\User',
        'object_id'   => $faker->randomNumber,
        'name'        => $faker->randomElement(['main', 'shipping', 'billing']),
        'name'        => $faker->firstName,
        'last_name'   => $faker->lastName,
        'address'     => $faker->streetAddress,
        'address_2'   => $faker->secondaryAddress,
        'city'        => $faker->city,
        'state'       => $faker->state,
        'postcode'    => $faker->postcode,
        'country'     => $faker->countryCode,
        'phone'       => $faker->phoneNumber,
        'fax'         => $faker->phoneNumber,
        'email'       => $faker->email,
    ];
});
