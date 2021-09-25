<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class UserAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        $faker = Factory::create();

        $eslam = User::whereUsername('eslam')->first();
        $egy   = Country::with('states')->whereId(65)->first();
        $state = $egy->states->random()->id;
        $city  = City::whereStateId($state)->inRandomOrder()->first()->id;

        $eslam->addresses()->create([
            'address_title'         => 'Home',
            'default_address'       => true,
            'first_name'            => 'Eslam',
            'last_name'             => 'Gamal',
            'email'                 => $faker->email,
            'mobile'                => $faker->phoneNumber,
            'address'               => $faker->address,
            'address2'              => $faker->secondaryAddress,
            'country_id'            => $egy->id,
            'state_id'              => $state,
            'city_id'               => $city,
            'zip_code'              => $faker->randomNumber(5),
            'po_box'                => $faker->randomNumber(4),
        ]);


        $eslam->addresses()->create([
            'address_title'         => 'Work',
            'default_address'       => false,
            'first_name'            => 'Eslam',
            'last_name'             => 'Gamal',
            'email'                 => $faker->email,
            'mobile'                => $faker->phoneNumber,
            'address'               => $faker->address,
            'address2'              => $faker->secondaryAddress,
            'country_id'            => 194,
            'state_id'              => 2861,
            'city_id'               => 102818,
            'zip_code'              => $faker->randomNumber(5),
            'po_box'                => $faker->randomNumber(4),
        ]);

        User::where('id', '>' , 3)->each(function($user) use($faker, $egy, $state, $city) {
            $user->addresses()->create([
                'address_title'         => 'Home',
                'default_address'       => true,
                'first_name'            => $faker->firstName,
                'last_name'             => $faker->lastName,
                'email'                 => $user->email,
                'mobile'                => $user->mobile,
                'address'               => $faker->address,
                'address2'              => $faker->secondaryAddress,
                'country_id'            => $egy->id,
                'state_id'              => $state,
                'city_id'               => $city,
                'zip_code'              => $faker->randomNumber(5),
                'po_box'                => $faker->randomNumber(4),
            ]);
        });

        Schema::enableForeignKeyConstraints();
    }
}
