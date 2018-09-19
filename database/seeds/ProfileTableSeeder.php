<?php

use Illuminate\Database\Seeder;

class ProfileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Model\Profile::class,10)->make()->each(function ($profile){
            $user = factory(App\User::class)->create();
            $profile->user()->associate($user);
            $profile->save();
        });
    }
}
