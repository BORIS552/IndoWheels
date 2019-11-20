<?php

use Illuminate\Database\Seeder;

class OutletsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Outlet::class, 16)->create()->each(function ($outlet) {
            //
        });
    }
}
