<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Faker\Generator as Faker;

class CustomerSeeder extends Seeder
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
        for( $i = 0; $i<10; $i++ ){
            $customer = new Customer();
            $customer->name = $faker->text();
            $customer->reference = $faker->text();
            $customer->category_id = $categories->random()->id;
            $customer->start_date = now()->subDays( rand( 20, 100 ) );
            $customer->description = $faker->paragraph();
            $customer->save();
        }
    }
}
