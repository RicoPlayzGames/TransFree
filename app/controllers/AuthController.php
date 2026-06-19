<?php

class AuthController {
    private $authService;
    private $config;

    public function __construct($db, $config) {
        $this->authService = new AuthService($db);
        $this->config = $config;
    }

    public function register() {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $repeatPassword = $_POST['repeat-password'];

        if (!$username || !$email || !$password) {
            $_SESSION['error'] = 'Please fill in all fields.';
            header('Location: ' . $this->config['base_path'] . '/register');
            exit;
        }

        if ($password !== $repeatPassword) {
            $_SESSION['error'] = 'Passwords do not match.';
            header('Location: ' . $this->config['base_path'] . '/register');
            exit;
        }

        try {
            $this->authService->registerUser($username, $email, $password);
            header('Location: ' . $this->config['base_path'] . '/upload');
            exit;
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: ' . $this->config['base_path'] . '/register');
            exit;
        }
    }

    public function login() {
        $name = $_POST['name'];
        $password = $_POST['password'];

        if (!$name || !$password) {
            $_SESSION['error'] = 'Please fill in all fields.';
            header('Location: ' . $this->config['base_path'] . '/login');
            exit;
        }

        $success = $this->authService->loginUser($name, $password);

        if (!$success) {
            $_SESSION['error'] = 'Invalid username or password.';
            header('Location: ' . $this->config['base_path'] . '/login');
            exit;
        }

        header('Location: ' . $this->config['base_path'] . '/upload');
        exit;
    }
}