<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\UserModel;

final class AuthController extends Controller
{
    public function login(): void
    {
        $this->render('partials/login', [
            'title' => 'Founder Login',
        ]);
    }

    public function authenticate(): void
    {
        $this->requirePost();

        $email = (string) $this->input('email');
        $password = (string) $this->input('password');

        remember_old(['email' => $email]);

        $errors = $this->requireFields([
            'email' => 'Email',
            'password' => 'Password',
        ]);

        if ($errors) {
            flash('message', ['text' => implode(' ', $errors), 'level' => 'danger']);
            redirect_to('/login');
        }

        $user = (new UserModel())->findByEmail($email);
        if (! $user || ! password_verify($password, $user['password_hash'])) {
            flash('message', ['text' => 'Invalid login credentials.', 'level' => 'danger']);
            redirect_to('/login');
        }

        clear_old();
        session_put('user', [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
        ]);

        $this->redirect(config('auth.default_redirect', '/dashboard'));
    }

    public function logout(): void
    {
        session_destroy();
        header('Location: ' . url('/login'));
        exit;
    }
}
