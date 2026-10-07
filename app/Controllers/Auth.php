<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('logged_in') === true) {
            return redirect()->to('/users');
        }

        return view('login');
    }

    public function attempt()
    {
        $username = trim((string) $this->request->getPost('username'));

        // Do not trim passwords: spaces can be valid password characters.
        $password = (string) $this->request->getPost('password');

        $data = [
            'username' => $username,
            'password' => $password,
        ];

        $rules = [
            'username' => 'required|max_length[50]',
            'password' => 'required|max_length[255]',
        ];

        if (! $this->validateData($data, $rules)) {
            return view('login', [
                'errors'   => $this->validator->getErrors(),
                'username' => $username,
            ]);
        }

        $user = (new UserModel())
            ->where('username', $username)
            ->first();

        $storedHash = is_array($user) ? ($user['password'] ?? '') : '';

        if (
            ! is_string($storedHash)
            || $storedHash === ''
            || ! password_verify($password, $storedHash)
        ) {
            return view('login', [
                'error'    => 'Invalid username or password.',
                'username' => $username,
            ]);
        }

        $session = session();

        // Prevent session fixation by replacing the old session ID.
        $session->regenerate(true);

        $session->set([
            'user_id'   => (int) $user['id'],
            'username'  => $user['username'],
            'logged_in' => true,
        ]);

        return redirect()->to('/users');
    }
    public function logout()
    {
        $session = session();
        $session->destroy();

        return redirect()->to(site_url('login'));
    }

    public function changePasswordForm()
{
    return view('change_password');
}


    public function changePassword()
    {
        $userId = (int) session()->get('user_id');

        if ($userId <= 0) {
            session()->destroy();

            return redirect()->to(site_url('login'));
        }

        // Do not trim passwords. Spaces can be valid password characters.
        $data = [
            'current_password'      => (string) $this->request->getPost('current_password'),
            'new_password'          => (string) $this->request->getPost('new_password'),
            'password_confirmation' => (string) $this->request->getPost('password_confirmation'),
        ];

        $rules = [
            'current_password' => [
                'label' => 'Current password',
                'rules' => 'required|max_length[255]',
            ],
            'new_password' => [
                'label' => 'New password',
                'rules' => 'required|min_length[8]|max_length[255]',
            ],
            'password_confirmation' => [
                'label'  => 'Password confirmation',
                'rules'  => 'required|matches[new_password]',
                'errors' => [
                    'matches' => 'The confirmation does not match your new password.',
                ],
            ],
        ];

        if (! $this->validateData($data, $rules)) {
            return view('change_password', [
                'errors' => $this->validator->getErrors(),
            ]);
        }

        $userModel = new UserModel();
        $user = $userModel->find($userId);

        $storedHash = is_array($user) ? ($user['password'] ?? '') : '';

        if (
            ! is_string($storedHash)
            || $storedHash === ''
            || ! password_verify($data['current_password'], $storedHash)
        ) {
            return view('change_password', [
                'errors' => [
                    'current_password' => 'Your current password is incorrect.',
                ],
            ]);
        }

        if (password_verify($data['new_password'], $storedHash)) {
            return view('change_password', [
                'errors' => [
                    'new_password' => 'Your new password must be different from your current password.',
                ],
            ]);
        }

        $newHash = password_hash($data['new_password'], PASSWORD_DEFAULT);

        if ($newHash === false || ! $userModel->update($userId, ['password' => $newHash])) {
            return view('change_password', [
                'errors' => [
                    'update' => 'Unable to change your password. Please try again.',
                ],
            ]);
        }

        // Keep the user logged in, but give them a fresh session ID.
        session()->regenerate(true);

        return redirect()
            ->to(site_url('account/password'))
            ->with('success', 'Your password has been changed successfully.');
    }
    
}