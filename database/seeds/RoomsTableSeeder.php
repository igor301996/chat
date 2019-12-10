<?php

use App\Room;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timeCreated = new Carbon();
        Room::create([
            'name' => 'Первая комната',
            'created_at' => $timeCreated,
            'updated_at' => $timeCreated,
        ]);

        Room::create([
            'name' => 'Вторая комната',
            'created_at' => $timeCreated,
            'updated_at' => $timeCreated,
        ]);
    }
}
