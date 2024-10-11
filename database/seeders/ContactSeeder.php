<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Schema;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        Schema::disableForeignKeyConstraints();
        Contact::truncate();
        Schema::enableForeignKeyConstraints();

        $faker = app( Faker::class );

        $customers = Customer::get();
        for( $i = 0; $i<10; $i++ ){
            $contact = new Contact();
            $contact->customer_id = $customers->random()->id;
            $contact->first_name = $faker->text();
            $contact->last_name = $faker->text();
            $contact->save();
        }
    }
}
