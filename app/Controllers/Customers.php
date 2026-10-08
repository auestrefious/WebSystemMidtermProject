<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class Customers extends BaseController
{
    public function index()
    {
        $customers = (new CustomerModel())->orderBy('id', 'DESC')->findAll();

        return view('customers/index', ['customers' => $customers]);
    }

    public function add()
    {
        return view('customers/add');
    }

    public function store()
    {
        $data = [
            'full_name' => trim((string) $this->request->getPost('full_name')),
            'email'     => trim((string) $this->request->getPost('email')),
            'phone'     => trim((string) $this->request->getPost('phone')),
        ];

        $rules = [
            'full_name' => 'required|max_length[100]',
            'email'     => 'required|valid_email|max_length[100]',
            'phone'     => 'permit_empty|max_length[20]',
        ];

        if (!$this->validateData($data, $rules)) {
            return redirect()->to(site_url('customers/new'))
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data['created_at'] = date('Y-m-d H:i:s');
        (new CustomerModel())->insert($data);

        return redirect()->to(site_url('customers'))
            ->with('message', 'Customer added.');
    }
    
    public function edit(int $id)
    {
        $customer = (new CustomerModel())->find($id);

        if (!$customer) {
            return redirect()->to(site_url('customers'))
                ->with('error', 'Customer not found.');
        }

        return view('customers/edit', ['customer' => $customer]);
    }

    public function update(int $id)
    {
        $model = new CustomerModel();

        if (!$model->find($id)) {
            return redirect()->to(site_url('customers'))
                ->with('error', 'Customer not found.');
        }

        $data = [
            'full_name' => trim((string) $this->request->getPost('full_name')),
            'email'     => trim((string) $this->request->getPost('email')),
            'phone'     => trim((string) $this->request->getPost('phone')),
        ];

        $rules = [
            'full_name' => 'required|max_length[100]',
            'email'     => 'required|valid_email|max_length[100]',
            'phone'     => 'permit_empty|max_length[20]',
        ];

        if (!$this->validateData($data, $rules)) {
            return redirect()->to(site_url("customers/{$id}/edit"))
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $model->update($id, $data);

        return redirect()->to(site_url('customers'))
            ->with('message', 'Customer updated.');
    }

    public function delete(int $id)
    {
        $model = new CustomerModel();

        if (!$model->find($id)) {
            return redirect()->to(site_url('customers'))
                ->with('error', 'Customer not found.');
        }

        $hasSales = db_connect()->table('sales')
            ->where('customer_id', $id)
            ->countAllResults() > 0;

        if ($hasSales) {
            return redirect()->to(site_url('customers'))
                ->with('error', 'This customer has a sale and cannot be deleted.');
        }

        $model->delete($id);

        return redirect()->to(site_url('customers'))
            ->with('message', 'Customer deleted.');
    }
}