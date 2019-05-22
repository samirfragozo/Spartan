<?php

use App\Client;
use App\Punch;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            factory(Client::class)->create([
                'active' => random_int(0, 1),
            ]);
        }

        for ($i = 0; $i < 50; $i++) {
            factory(Punch::class)->create([
                'client_id' => random_int(1, Client::count()),
            ]);
        }
    }
}
