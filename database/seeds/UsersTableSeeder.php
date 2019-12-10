<?php

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timeCreated = new Carbon();
        User::create([
            'name' => 'Иван',
            'email' => 'ivan.lab@yandex.ru',
            'password' => Hash::make('12341234'),
            'created_at' => $timeCreated,
            'updated_at' => $timeCreated,
        ]);

        User::create([
            'name' => 'Сергей',
            'email' => 'sergei.lab@yandex.ru',
            'password' => Hash::make('12341234'),
            'created_at' => $timeCreated,
            'updated_at' => $timeCreated,
        ]);
    }
}
