<?php

namespace App\Controllers;

class Customers extends BaseController
{
    public function index()
    {
        $customers = [
            ['id' => 1, 'name' => 'Ana Reyes',   'email' => 'ana@example.com'],
            ['id' => 2, 'name' => 'Ben Cruz',    'email' => 'ben@example.com'],
            ['id' => 3, 'name' => 'Cara Santos', 'email' => 'cara@example.com'],
            ['id' => 4, 'name' => 'Diego Lim',   'email' => 'diego@example.com'],
            ['id' => 5, 'name' => 'Ella Tan',    'email' => 'ella@example.com'],
        ];

        // Temporary output until you create a Customers view:
        return view('customer_accounts', ['customers' => $customers]);
    }
}