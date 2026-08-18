<?php

namespace App\Controllers;

use League\OAuth2\Client\Provider\Google;

class Auth extends BaseController
{
    protected function googleProvider(): Google
    {
        return new Google([
            'clientId'     => env('GOOGLE_CLIENT_ID'),
            'clientSecret' => env('GOOGLE_CLIENT_SECRET'),
            'redirectUri'  => env('GOOGLE_REDIRECT_URI'),
        ]);
    }

    public function login()
    {
        return view('auth/login');
    }

    public function google()
    {
        $provider = $this->googleProvider();

        $authUrl = $provider->getAuthorizationUrl([
            'prompt' => 'select_account',
        ]);

        session()->set('oauth2state', $provider->getState());

        return redirect()->to($authUrl);
    }

    public function googleCallback()
    {
        $provider = $this->googleProvider();

        $state = $this->request->getGet('state');

        if (!$state || $state !== session()->get('oauth2state')) {
            session()->remove('oauth2state');
            return redirect()->to(base_url('login'))->with('error', 'Sesi login tidak valid, silakan coba lagi.');
        }
        session()->remove('oauth2state');

        if ($this->request->getGet('error')) {
            return redirect()->to(base_url('login'))->with('error', 'Login dengan Google dibatalkan.');
        }

        try {
            $token = $provider->getAccessToken('authorization_code', [
                'code' => $this->request->getGet('code'),
            ]);

            $googleUser = $provider->getResourceOwner($token);
            $data = $googleUser->toArray();

            $userModel = new \App\Models\UserModel();

            $user = $userModel->where('google_id', $data['sub'])->first();

            if (!$user) {
                $user = $userModel->where('email', $data['email'])->first();
            }

            if ($user) {
                $userModel->update($user['id'], [
                    'google_id' => $data['sub'],
                    'foto'      => $data['picture'] ?? null,
                ]);
            } else {
                $userId = $userModel->insert([
                    'nama'      => $data['name'],
                    'email'     => $data['email'],
                    'google_id' => $data['sub'],
                    'foto'      => $data['picture'] ?? null,
                    'password'  => null,
                ]);
                $user = $userModel->find($userId);
            }

            session()->set([
                'user_id'    => $user['id'],
                'user_nama'  => $user['nama'],
                'user_email' => $user['email'],
                'logged_in'  => true,
            ]);

            return redirect()->to(base_url('dashboard'));

        } catch (\Exception $e) {
            log_message('error', 'Google login error: ' . $e->getMessage());
            return redirect()->to(base_url('login'))->with('error', 'Login dengan Google gagal, silakan coba lagi.');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'))->with('sukses', 'Berhasil keluar!');
    }
}