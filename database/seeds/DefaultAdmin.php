<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new User;
        $admin->name = "Admin";
        $admin->email = "ctf@example.org";
        $admin->admin = true;
        $admin->password = Hash::make('password');
        $admin->save();
    }
}
