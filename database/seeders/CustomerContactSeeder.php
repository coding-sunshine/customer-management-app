<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Faker\Generator as Faker;

class CustomerContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Schema::disableForeignKeyConstraints();
        Customer::truncate();
        Schema::enableForeignKeyConstraints();

        $faker = app( Faker::class );

        $categories = Category::get();

        for ($i = 1; $i <= 10; $i++) {
            $customer = Customer::create([
                'name' => "Customer $i",
                'reference' => "CUST$i",
                'category_id' => $categories->random()->id,
                'start_date' => now()->subDays(rand(1, 365)),
                'description' => "Description for Customer $i",
            ]);

            for ($j = 1; $j <= rand(1, 5); $j++) {
                Contact::create([
                    'customer_id' => $customer->id,
                    'first_name' => "FirstName$j",
                    'last_name' => "LastName$j",
                ]);
            }
        }
    }
}
