<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
    public function index()
    {
        $model = new UserModel();

        return view('users/index', [
            'users' => $model->orderBy('id', 'DESC')->findAll(),
        ]);
    }

    public function new()
    {
        return view('users/new');
    }

    public function create()
    {
        $model = new UserModel();

        $data = [
            'username'  => trim((string) $this->request->getPost('username')),
            'full_name' => trim((string) $this->request->getPost('full_name')),
        ];

        $rules = [
            'username'  => 'required|max_length[50]|is_unique[users.username]',
            'full_name' => 'required|max_length[100]',
        ];

        if (!$this->validateData($data, $rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $password = (string) $this->request->getPost('password');

        if (strlen($password) < 6) {
            return redirect()->back()
                ->withInput()
                ->with('errors', [
                    'password' => 'Password must be at least 6 characters.',
                ]);
        }

        $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        $data['created_at'] = date('Y-m-d H:i:s');

        $avatar = $this->request->getFile('avatar');

        if ($avatar && $avatar->isValid() && !$avatar->hasMoved()) {
            $avatarRules = [
                'avatar' => 'is_image[avatar]'
                    . '|mime_in[avatar,image/jpg,image/jpeg,image/png]'
                    . '|ext_in[avatar,jpg,jpeg,png]'
                    . '|max_size[avatar,2048]',
            ];

            if (!$this->validateData([], $avatarRules)) {
                return redirect()->back()
                    ->withInput()
                    ->with('errors', $this->validator->getErrors());
            }

            $filename = bin2hex(random_bytes(16)) . '.jpg';
            $destination = FCPATH . 'uploads/avatars/' . $filename;

            service('image')
                ->withFile($avatar->getTempName())
                ->fit(200, 200, 'center')
                ->save($destination, 80);

            $data['avatar'] = $filename;
        }

        $model->insert($data);

        return redirect()->to(site_url('users'))
            ->with('message', 'Staff member added successfully.');
    }

    public function edit(int $id)
    {
        $user = (new UserModel())->find($id);

        if (!$user) {
            return redirect()->to(site_url('users'))
                ->with('error', 'Staff member not found.');
        }

        return view('users/edit', [
            'user' => $user,
        ]);
    }

    public function update(int $id)
    {
        $model = new UserModel();
        $user = $model->find($id);

        if (!$user) {
            return redirect()->to(site_url('users'))
                ->with('error', 'Staff member not found.');
        }

        $data = [
            'username'  => trim((string) $this->request->getPost('username')),
            'full_name' => trim((string) $this->request->getPost('full_name')),
        ];

        $rules = [
            'username'  => "required|max_length[50]|is_unique[users.username,id,{$id}]",
            'full_name' => 'required|max_length[100]',
        ];

        if (!$this->validateData($data, $rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $password = (string) $this->request->getPost('password');

        if ($password !== '') {
            if (strlen($password) < 6) {
                return redirect()->back()
                    ->withInput()
                    ->with('errors', [
                        'password' => 'Password must be at least 6 characters.',
                    ]);
            }

            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $avatar = $this->request->getFile('avatar');
        $newAvatar = null;

        if ($avatar && $avatar->isValid() && !$avatar->hasMoved()) {
            $avatarRules = [
                'avatar' => 'is_image[avatar]'
                    . '|mime_in[avatar,image/jpg,image/jpeg,image/png]'
                    . '|ext_in[avatar,jpg,jpeg,png]'
                    . '|max_size[avatar,2048]',
            ];

            if (!$this->validateData([], $avatarRules)) {
                return redirect()->back()
                    ->withInput()
                    ->with('errors', $this->validator->getErrors());
            }

            $newAvatar = bin2hex(random_bytes(16)) . '.jpg';
            $destination = FCPATH . 'uploads/avatars/' . $newAvatar;

            service('image')
                ->withFile($avatar->getTempName())
                ->fit(200, 200, 'center')
                ->save($destination, 80);

            $data['avatar'] = $newAvatar;
        }

        $model->update($id, $data);

        if ($newAvatar && !empty($user['avatar'])) {
            $oldAvatar = FCPATH . 'uploads/avatars/' . basename($user['avatar']);

            if (is_file($oldAvatar)) {
                unlink($oldAvatar);
            }
        }

        return redirect()->to(site_url('users'))
            ->with('message', 'Staff member updated successfully.');
    }

    public function delete(int $id)
    {
        $model = new UserModel();
        $user = $model->find($id);

        if (!$user) {
            return redirect()->to(site_url('users'))
                ->with('error', 'Staff member not found.');
        }

        if (!empty($user['avatar'])) {
            $avatarPath = FCPATH . 'uploads/avatars/' . basename($user['avatar']);

            if (is_file($avatarPath)) {
                unlink($avatarPath);
            }
        }

        $model->delete($id);

        return redirect()->to(site_url('users'))
            ->with('message', 'Staff member deleted successfully.');
    }
}