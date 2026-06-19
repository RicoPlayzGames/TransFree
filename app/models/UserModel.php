<?php

class UserModel {
	private $db;

	// Slaat database connectie op
	public function __construct($db) {
		$this->db = $db;
	}

	// Haalt alle users uit de database
	public function getAllUsers() {
		return $this->db->queryDatabase(
			"SELECT id, username, email, role, created_at FROM users ORDER BY created_at DESC",
			[]
		)->fetchAll();
	}

	// Haalt de gebruiker uit de database aan de hand van de id
	public function getUserById($id) {
		return $this->db->queryDatabase(
			"SELECT id, username, email, role, created_at FROM users WHERE id = :id",
			['id' => $id]
		)->fetch();
	}

	// De role van de user updaten aan de hand van de id
	public function updateUserRole($id, $role) {
		return $this->db->queryDatabase(
			"UPDATE users SET role = :role WHERE id = :id",
			['role' => $role, 'id' => $id]
		);
	}

	// Delete de user aan de hand van de id
	public function deleteUserById($id) {
		return $this->db->queryDatabase(
			"DELETE FROM users WHERE id = :id",
			['id' => $id]
		);
	}
}

