<?php

namespace App\Controllers;

class Users extends BaseController
{
    public function index()
    {
        $users = [
            ['id' => 1, 'username' => 'areyes',  'email' => 'ana@example.com',   'role' => 'Admin'],
            ['id' => 2, 'username' => 'bcruz',   'email' => 'ben@example.com',   'role' => 'Editor'],
            ['id' => 3, 'username' => 'csantos', 'email' => 'cara@example.com',  'role' => 'User'],
            ['id' => 4, 'username' => 'dlim',    'email' => 'diego@example.com','role' => 'User'],
            ['id' => 5, 'username' => 'etan',    'email' => 'ella@example.com', 'role' => 'Editor'],
        ];

        // Temporary output until you create a Users view:
        return view('user_accounts', ['users' => $users]);
    }
}