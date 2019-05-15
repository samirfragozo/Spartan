<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'admin']);

        factory(User::class)->create([
            'email' => 'admin@orioncol.com',
        ])->assignRole('admin');
    }
}
