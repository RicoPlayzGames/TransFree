<?php
// Haalt de request op uit auth service
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

        if (strlen($username) < 3 || strlen($username) > 50) {
            $errors[] = 'Username must be between 3 and 50 characters';
        }

        if (strlen($email) > 255) {
            $errors[] = 'Email may not exceed 255 characters';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please enter a valid email address';
        }

        if (strlen($password) < 8 || strlen($password) > 255) {
            $errors[] = 'Password must be between 8 and 255 characters';
        }

        if (!empty($errors)) {
            $_SESSION['flash_error'] = implode(' - ', $errors);
            header('Location: ' . $this->config['base_path'] . '/register');
            exit;
        }

        try {
            $this->authService->registerUser($username, $email, $password);
            $_SESSION['flash_success'] = 'Registration successful. You are now logged in.';
            header('Location: ' . $this->config['base_path'] . '/dashboard');
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

        $errors = [];

        if ($name === '' || $password === '') {
            $errors[] = 'Please fill in all fields.';
        }

        if (strlen($name) > 255) {
            $errors[] = 'Username or email may not exceed 255 characters.';
        }

        if (strlen($password) > 255) {
            $errors[] = 'Password may not exceed 255 characters.';
        }

        if (!empty($errors)) {
            $_SESSION['flash_error'] = implode(' ', $errors);
            header('Location: ' . $this->config['base_path'] . '/login');
            exit;
        }

        $success = $this->authService->loginUser($name, $password);

        if (!$success) {
            $_SESSION['flash_error'] = 'Username or password is incorrect.';
            header('Location: ' . $this->config['base_path'] . '/login');
            exit;
        }

        // session regeneraten bij login, voorkomt dat mensen bestaande sessie id's misbruikn
        session_regenerate_id(true);

        if ($_SESSION['role'] === 'admin') {
            header('Location: ' . $this->config['base_path'] . '/admin');
        } else {
            header('Location: ' . $this->config['base_path'] . '/dashboard');
        }

        exit;
    }
}