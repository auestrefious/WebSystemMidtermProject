<?php

namespace App\Controllers;

use App\Models\SaleModel;
use App\Models\ProductModel;
use App\Models\CustomerModel;

class Sales extends BaseController
{
    public function record()
    {
        $productModel = new ProductModel();
        $customerModel = new CustomerModel();

        return view('sales/record', [
            'products' => $productModel->findAll(),
            'customers' => $customerModel->findAll()
        ]);
    }

    public function store()
    {
        $productId = (int) $this->request->getPost('product_id');
        $customerId = $this->request->getPost('customer_id');
        $quantity = (int) $this->request->getPost('quantity');

        $staffId = session()->get('staff_id');

        if (!$staffId) {
            return redirect()->to('/login');
        }

        if ($productId <= 0 || $quantity <= 0) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Please enter a valid product and quantity.');
        }

        $db = \Config\Database::connect();
        $productModel = new ProductModel();
        $saleModel = new SaleModel();

        $product = $productModel->find($productId);

        if (!$product) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Product not found.');
        }

        if ($customerId !== null && $customerId !== '') {
            $customerModel = new CustomerModel();

            if (!$customerModel->find($customerId)) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Invalid customer selected.');
            }
        }

        $db->transBegin();

        try {
            // Deduct stock only when enough is available.
            $db->table('products')
                ->where('id', $productId)
                ->where('stock_quantity >=', $quantity)
                ->set('stock_quantity', 'stock_quantity - ' . $quantity, false)
                ->update();

            if ($db->affectedRows() !== 1) {
                $db->transRollback();

                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Insufficient stock for this sale.');
            }

            $totalPrice = round((float) $product['price'] * $quantity, 2);

            $saved = $saleModel->insert([
                'product_id' => $productId,
                'customer_id' => $customerId ?: null,
                'sold_by' => $staffId,
                'quantity' => $quantity,
                'total_price' => $totalPrice,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            if (!$saved || $db->transStatus() === false) {
                throw new \RuntimeException('Sale could not be saved.');
            }

            $db->transCommit();

            return redirect()->to('/sales/record')
                ->with('success', 'Sale recorded successfully!');

        } catch (\Throwable $e) {
            $db->transRollback();

            log_message('error', 'Sale failed: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Unable to record sale. Please try again.');
        }
    }

    
    public function history()
    {
        $saleModel = new \App\Models\SaleModel();

        $data = [
            'sales' => $saleModel->getSalesHistory()
        ];

        return view('sales/history', $data);
    }

}
