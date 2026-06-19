<?php

class UserModel {
	private $db;

	public function __construct($db) {
		$this->db = $db;
	}

	public function getAllUsers() {
		return $this->db->queryDatabase(
			"SELECT id, username, email, role, created_at FROM users ORDER BY created_at DESC",
			[]
		)->fetchAll();
	}

	public function getUserById($id) {
		return $this->db->queryDatabase(
			"SELECT id, username, email, role, created_at FROM users WHERE id = :id",
			['id' => $id]
		)->fetch();
	}

	public function updateUserRole($id, $role) {
		return $this->db->queryDatabase(
			"UPDATE users SET role = :role WHERE id = :id",
			['role' => $role, 'id' => $id]
		);
	}

	public function deleteUserById($id) {
		return $this->db->queryDatabase(
			"DELETE FROM users WHERE id = :id",
			['id' => $id]
		);
	}
}

