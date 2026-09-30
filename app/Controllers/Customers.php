<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class Customers extends BaseController
{
    public function index()
    {
        $customerModel = new CustomerModel();

        return view('customer_accounts', [
            'customers' => $customerModel->findAll(),
        ]);
    }
}