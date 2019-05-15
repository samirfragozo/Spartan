<?php

use App\Client;
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
        for ($i = 0; $i < 50; $i++) {
            factory(Client::class)->create([
                'active' => random_int(0, 1),
            ]);
        }
    }
}
