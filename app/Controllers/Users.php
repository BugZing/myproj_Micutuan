<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Users extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();

        return view('user_accounts', [
            'users' => $userModel->findAll(),
        ]);
    }
    public function new()
    {
        return view('new_user');
    }

    public function create()
    {
        $data = [
            'username'  => $this->request->getPost('username'),
            'full_name' => $this->request->getPost('full_name'),
        ];

        $rules = [
            'username' => [
                'label'  => 'Username',
                'rules'  => 'required|max_length[50]|is_unique[users.username]',
                'errors' => [
                    'is_unique' => 'That username is already taken.',
                ],
            ],
            'full_name' => [
                'label' => 'Full Name',
                'rules' => 'required|max_length[100]',
            ],
        ];

        if (! $this->validateData($data, $rules)) {
            return view('new_user', [
                'errors' => $this->validator->getErrors(),
                'user'   => $data,
            ]);
        }

        $userModel = new UserModel();
        $userModel->insert($this->validator->getValidated());

        return redirect()->to('/users');
    }
    public function edit($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if ($user === null) {
            throw PageNotFoundException::forPageNotFound('User not found.');
        }

        return view('edit_user', [
            'user' => $user,
        ]);
    }

    public function update($id)
    {
        $userModel = new UserModel();
        $existingUser = $userModel->find($id);

        if ($existingUser === null) {
            throw PageNotFoundException::forPageNotFound('User not found.');
        }

        $data = [
            'username'  => $this->request->getPost('username'),
            'full_name' => $this->request->getPost('full_name'),
        ];

        $avatar = $this->request->getFile('avatar');
        
        $hasNewAvatar = $avatar !== null
            && $avatar->getError() !== UPLOAD_ERR_NO_FILE;

        $textRules = [
            'username' => [
                'label'  => 'Username',
                'rules'  => 'required|max_length[50]|is_unique[users.username,id,' . $id . ']',
                'errors' => [
                    'is_unique' => 'That username is already taken.',
                ],
            ],
            'full_name' => [
                'label' => 'Full Name',
                'rules' => 'required|max_length[100]',
            ],
        ];

        if (! $this->validateData($data, $textRules)) {
            return view('edit_user', [
                'errors' => $this->validator->getErrors(),
                'user'   => array_merge($existingUser, $data),
            ]);
        }

        $validatedData = $this->validator->getValidated();

        if ($hasNewAvatar) {
            $avatarRules = [
                'avatar' => [
                    'label' => 'Profile picture',
                    'rules' => 'uploaded[avatar]|is_image[avatar]|mime_in[avatar,image/jpeg,image/png]|ext_in[avatar,jpg,jpeg,png]|max_size[avatar,2048]',
                    'errors' => [
                        'mime_in'  => 'Profile picture must be a JPG or PNG.',
                        'ext_in'   => 'Profile picture must be a JPG or PNG.',
                        'max_size' => 'Profile picture must be 2 MB or smaller.',
                    ],
                ],
            ];

            if (! $this->validateData([], $avatarRules)) {
                return view('edit_user', [
                    'errors' => $this->validator->getErrors(),
                    'user'   => array_merge($existingUser, $data),
                ]);
            }
        }

        $updateData = [
            'username'  => $validatedData['username'],
            'full_name' => $validatedData['full_name'],
        ];

        $newAvatarFilename = null;
        $newAvatarPath = null;

        if ($hasNewAvatar) {
            try {
                [$newAvatarFilename, $newAvatarPath] = $this->createAvatarThumbnail($avatar);
                $updateData['avatar'] = $newAvatarFilename;
            } catch (\Throwable $e) {
                log_message('error', 'Avatar processing failed: {message}', [
                    'message' => $e->getMessage(),
                ]);

                return view('edit_user', [
                    'errors' => [
                        'avatar' => ENVIRONMENT === 'development'
                            ? 'Avatar processing failed: ' . $e->getMessage()
                            : 'The profile picture could not be processed. Please try another JPG or PNG file.',
                    ],
                    'user' => array_merge($existingUser, $data),
                ]);
            }
        }

        try {
            $updated = $userModel->update($id, $updateData);
        } catch (\Throwable $e) {
            if ($newAvatarPath !== null && is_file($newAvatarPath)) {
                unlink($newAvatarPath);
            }

            throw $e;
        }

        if (! $updated) {
            if ($newAvatarPath !== null && is_file($newAvatarPath)) {
                unlink($newAvatarPath);
            }

            return view('edit_user', [
                'errors' => [
                    'update' => 'Unable to update this user. Please try again.',
                ],
                'user' => array_merge($existingUser, $data),
            ]);
        }

        // Delete the previous avatar only after the database update succeeds.
        if ($newAvatarFilename !== null) {
            $oldAvatar = basename((string) ($existingUser['avatar'] ?? ''));

            if ($oldAvatar !== '') {
                $oldAvatarPath = FCPATH . 'uploads/avatars/' . $oldAvatar;

                if (is_file($oldAvatarPath)) {
                    unlink($oldAvatarPath);
                }
            }
        }

        return redirect()->to('/users');
    }

    private function createAvatarThumbnail($avatar): array
    {
        $uploadDirectory = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'avatars';

        if (! is_dir($uploadDirectory) && ! mkdir($uploadDirectory, 0775, true) && ! is_dir($uploadDirectory)) {
            throw new \RuntimeException(
                'Cannot create public/uploads/avatars. Check that the public folder is writable.'
            );
        }

        if (! is_writable($uploadDirectory)) {
            throw new \RuntimeException(
                'public/uploads/avatars is not writable. Check its folder permissions.'
            );
        }

        if (! extension_loaded('gd')) {
            throw new \RuntimeException(
                'PHP GD is not enabled. Enable extension=gd in the php.ini used by your local server, then restart the server.'
            );
        }

        if (! is_file($avatar->getTempName())) {
            throw new \RuntimeException(
                'The uploaded temporary image file is no longer available.'
            );
        }

        $mime = $avatar->getMimeType();
        $extension = $mime === 'image/png' ? 'png' : 'jpg';

        if ($extension === 'jpg' && ! function_exists('imagecreatefromjpeg')) {
            throw new \RuntimeException(
                'GD is enabled but JPEG support is unavailable.'
            );
        }

        if ($extension === 'png' && ! function_exists('imagecreatefrompng')) {
            throw new \RuntimeException(
                'GD is enabled but PNG support is unavailable.'
            );
        }

        $filename = 'avatar_' . bin2hex(random_bytes(16)) . '.' . $extension;
        $path = $uploadDirectory . DIRECTORY_SEPARATOR . $filename;

        try {
            service('image', 'gd')
                ->withFile($avatar->getTempName())
                ->fit(200, 200, 'center')
                ->save($path, 90);

            if (! is_file($path)) {
                throw new \RuntimeException(
                    'The thumbnail was not written to public/uploads/avatars.'
                );
            }
        } catch (\Throwable $e) {
            if (is_file($path)) {
                unlink($path);
            }

            throw $e;
        }

        return [$filename, $path];
    }
    
    
}