<?php
namespace App\Controllers;

use App\Models\CustomerModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Customers extends BaseController
{
    public function index()
    {
        $customerModel = new CustomerModel();

        return view('customer_accounts', [
            'customers' => $customerModel->findAll(),
        ]);
    }
    public function new()
    {
        return view('new_customer');
    }

    public function create()
    {
        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'email'     => $this->request->getPost('email'),
            'phone'     => $this->request->getPost('phone'),
        ];

        $rules = [
            'full_name' => 'required',
            'email'     => 'required|valid_email',
            'phone'     => 'permit_empty|max_length[20]',
        ];

        if (! $this->validateData($data, $rules)) {
            return view('new_customer', [
                'errors'   => $this->validator->getErrors(),
                'customer' => $data,
            ]);
        }

        $customerModel = new CustomerModel();
        $customerModel->insert($this->validator->getValidated());

        return redirect()->to('/customers');

        
    }

    public function edit($id)
    {
        $customerModel = new CustomerModel();
        $customer = $customerModel->find($id);

        if ($customer === null) {
            throw PageNotFoundException::forPageNotFound('Customer not found.');
        }

        return view('edit_customer', [
            'customer' => $customer,
        ]);
    }

    public function update($id)
    {
        $customerModel = new CustomerModel();
        $existingCustomer = $customerModel->find($id);

        if ($existingCustomer === null) {
            throw PageNotFoundException::forPageNotFound('Customer not found.');
        }

        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'email'     => $this->request->getPost('email'),
            'phone'     => $this->request->getPost('phone'),
        ];

        $rules = [
            'full_name' => 'required|max_length[100]',
            'email'     => 'required|valid_email|max_length[100]',
            'phone'     => 'permit_empty|max_length[20]',
        ];

        if (! $this->validateData($data, $rules)) {
            return view('edit_customer', [
                'errors'   => $this->validator->getErrors(),
                'customer' => array_merge($existingCustomer, $data),
            ]);
        }

        $customerModel->update($id, $this->validator->getValidated());

        return redirect()->to('/customers');
    }   
}