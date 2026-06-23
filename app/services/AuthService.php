<?php

class AuthService {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function registerUser($username, $email, $password) {
        // hash voor wachtwoorden:
        // PHP Password_hash om een hash te maken
        // `PASSWORD_DEFAULT` voor het algoritme
        // hash komt in de database
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $this->db->queryDatabase(
            "INSERT INTO users (username, password, email, role) 
            VALUES (:username, :password, :email, :role)",
            [
                "username" => $username,
                "password" => $hash,
                "email" => $email,
                "role" => "gebruiker",
            ]
        );

        $user = $this->db->queryDatabase(
            "SELECT * FROM users WHERE email = :email",
            [
                "email" => $email,
            ]
        )->fetch();

        $_SESSION["username"] = $user["username"];
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["email"] = $user["email"];
        $_SESSION["role"] = $user["role"];

        return $this->db->queryDatabase(
            "SELECT * FROM users WHERE email = :email",
            [
                "email" => $email
            ]
        )->fetch();
    }

    // Functie voor de gebruiker om in te loggen
    public function loginUser($name, $password) {
        $user = $this->db->queryDatabase(
            "SELECT * FROM users WHERE email = :name OR username = :name",
            [
                "name" => $name
            ]
        )->fetch();

        if (!$user || !password_verify($password, $user['password'])) {
            return false;
        }

        $_SESSION["username"] = $user["username"];
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["email"] = $user["email"];
        $_SESSION["role"] = $user["role"];

        return $user;
    }
}