<?php

class AuthController {
    private $authService;
    private $config;

    public function __construct($db, $config) {
        $this->authService = new AuthService($db);
        $this->config = $config;
    }

    public function register() {
        $username = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $repeatPassword = $_POST['password_confirm'] ?? '';

        $errors = [];
        if ($username === '' || $email === '' || $password === '') {
            $errors[] = 'Please fill in all fields';
        }

        if ($password !== $repeatPassword) {
            $errors[] = 'Passwords do not match';
        }

        if (!empty($errors)) {
            $_SESSION['flash_error'] = implode(' - ', $errors);
            header('Location: ' . $this->config['base_path'] . '/register');
            exit;
        }

        try {
            $this->authService->registerUser($username, $email, $password);
            $_SESSION['flash_success'] = 'Registration successful. You are now logged in.';
            header('Location: ' . $this->config['base_path'] . '/upload');
            exit;
        } catch (Exception $e) {
            $_SESSION['flash_error'] = $e->getMessage();
            header('Location: ' . $this->config['base_path'] . '/register');
            exit;
        }
    }
    public function login() {
        $name = trim($_POST['name'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($name === '' || $password === '') {
            $_SESSION['flash_error'] = 'Please fill in all fields.';
            header('Location: ' . $this->config['base_path'] . '/login');
            exit;
        }

        $success = $this->authService->loginUser($name, $password);

        if (!$success) {
            $_SESSION['flash_error'] = 'Username or password is incorrect.';
            header('Location: ' . $this->config['base_path'] . '/login');
            exit;
        }

        header('Location: ' . $this->config['base_path'] . '/upload');
        exit;
    }
}