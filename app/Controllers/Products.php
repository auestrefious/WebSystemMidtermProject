<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Products extends BaseController
{
    public function index()
    {
        $products = (new ProductModel())->orderBy('id', 'DESC')->findAll();

        return view('products/index', ['products' => $products]);
    }

    public function add()
    {
        return view('products/add');
    }

    public function store()
    {
        $data = [
            'name'           => trim((string) $this->request->getPost('name')),
            'price'          => trim((string) $this->request->getPost('price')),
            'stock_quantity' => trim((string) $this->request->getPost('stock_quantity')),
        ];

        $back = static function (array $errors) {
            return redirect()->to(site_url('products/new'))
                ->withInput()
                ->with('errors', $errors);
        };

        $rules = [
            'name'           => 'required|max_length[100]',
            'price'          => 'required|decimal|greater_than_equal_to[0]',
            'stock_quantity' => 'required|integer|greater_than_equal_to[0]'
                . '|less_than_equal_to[2147483647]',
        ];

        if (!$this->validateData($data, $rules)) {
            return $back($this->validator->getErrors());
        }

        // DECIMAL(10,2): up to 8 digits before the point and 2 after it.
        if (!preg_match('/^\d{1,8}(?:\.\d{1,2})?$/', $data['price'])) {
            return $back(['price' => 'Enter a price with at most two decimal places.']);
        }

        $imageRules = [
            'image' => 'uploaded[image]|is_image[image]'
                . '|mime_in[image,image/jpeg,image/png]'
                . '|ext_in[image,jpg,jpeg,png]'
                . '|max_size[image,2048]'
                . '|max_dims[image,4000,4000]',
        ];

        if (!$this->validateData([], $imageRules)) {
            return $back($this->validator->getErrors());
        }

        $image = $this->request->getFile('image');
        $extension = $image->getMimeType() === 'image/png' ? 'png' : 'jpg';
        $filename = bin2hex(random_bytes(16)) . '.' . $extension;
        $destination = FCPATH . 'uploads/products/' . $filename;

        try {
            service('image')
                ->withFile($image->getTempName())
                ->fit(400, 400, 'center')
                ->save($destination);
        } catch (\Throwable $e) {
            return $back(['image' => 'The image could not be prepared.']);
        }

        $data['image'] = $filename;
        $data['created_at'] = date('Y-m-d H:i:s');

        (new ProductModel())->insert($data);

        return redirect()->to(site_url('products'))
            ->with('message', 'Product added.');
    }
    
    public function edit(int $id)
    {
        $product = (new ProductModel())->find($id);

        if (!$product) {
            return redirect()->to(site_url('products'))
                ->with('error', 'Product not found.');
        }

        return view('products/edit', ['product' => $product]);
    }

    public function update(int $id)
    {
        $model = new ProductModel();
        $product = $model->find($id);

        if (!$product) {
            return redirect()->to(site_url('products'))
                ->with('error', 'Product not found.');
        }

        $data = [
            'name'           => trim((string) $this->request->getPost('name')),
            'price'          => trim((string) $this->request->getPost('price')),
            'stock_quantity' => trim((string) $this->request->getPost('stock_quantity')),
        ];

        $back = static function (array $errors) use ($id) {
            return redirect()->to(site_url("products/{$id}/edit"))
                ->withInput()
                ->with('errors', $errors);
        };

        $rules = [
            'name'           => 'required|max_length[100]',
            'price'          => 'required|decimal|greater_than_equal_to[0]',
            'stock_quantity' => 'required|integer|greater_than_equal_to[0]'
                . '|less_than_equal_to[2147483647]',
        ];

        if (!$this->validateData($data, $rules)) {
            return $back($this->validator->getErrors());
        }

        if (!preg_match('/^\d{1,8}(?:\.\d{1,2})?$/', $data['price'])) {
            return $back(['price' => 'Enter a price with at most two decimal places.']);
        }

        $image = $this->request->getFile('image');
        $newFilename = null;
        $folder = FCPATH . 'uploads/products/';

        if ($image && $image->getError() !== UPLOAD_ERR_NO_FILE) {
            $imageRules = [
                'image' => 'uploaded[image]|is_image[image]'
                    . '|mime_in[image,image/jpeg,image/png]'
                    . '|ext_in[image,jpg,jpeg,png]'
                    . '|max_size[image,2048]'
                    . '|max_dims[image,4000,4000]',
            ];

            if (!$this->validateData([], $imageRules)) {
                return $back($this->validator->getErrors());
            }

            $extension = $image->getMimeType() === 'image/png' ? 'png' : 'jpg';
            $newFilename = bin2hex(random_bytes(16)) . '.' . $extension;

            try {
                service('image')
                    ->withFile($image->getTempName())
                    ->fit(400, 400, 'center')
                    ->save($folder . $newFilename);
            } catch (\Throwable $e) {
                return $back(['image' => 'The image could not be prepared.']);
            }

            $data['image'] = $newFilename;
        }

        $model->update($id, $data);

        if ($newFilename && $product['image']) {
            $oldPath = $folder . basename($product['image']);

            if (is_file($oldPath)) {
                unlink($oldPath);
            }
        }

        return redirect()->to(site_url('products'))
            ->with('message', 'Product updated.');
    }

    public function archive(int $id)
    {
        $model = new ProductModel();

        if (!$model->find($id)) {
            return redirect()->to(site_url('products'))
                ->with('error', 'Product not found.');
        }

        $model->delete($id);

        return redirect()->to(site_url('products'))
            ->with('message', 'Product archived.');
    }
}