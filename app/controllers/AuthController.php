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
            echo "Please fill in all fields";
        }

        if ($password !== $repeatPassword) {
            echo "Passwords do not match";
        }

        $this->authService->registerUser($username, $email, $password);

        header("Location: upload");
        exit;
    }

    public function login() {
        $name = $_POST['name'];
        $password = $_POST['passsword'];

        if (!$name || !$password) {
            echo "Fill in all fields buddy";
        }

        $success = $this->authService->loginUser($name, $password);

        if (!$success) {
            echo "Invalid credentials";
        }

        header("Location: upload");
        exit;
    }
}