<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\User::class, 5)->create()->each(function ($user) {
        //     // $user->posts()->save(factory(App\Post::class)->make());
        // });

        for ($i = 0; $i < 7; $i++) {
            $date = date('Y-m-d H:i:s', strtotime("+ $i day"));
            factory(App\User::class, mt_rand(50, 100))->make()->each(function ($user) use ($date) {
                $user->created_at = $date;
                $user->updated_at = $date;
                $user->save();
            });
        }

    }
}
