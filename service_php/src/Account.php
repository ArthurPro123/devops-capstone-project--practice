<?php
require_once __DIR__ . '/../config/database.php';
class Account {
    private $conn;
    public function __construct() {
        $this->conn = getDBConnection();
    }
    // Create a new account
    public function create($name, $email, $address, $phone_number) {
        $stmt = $this->conn->prepare("INSERT INTO accounts (name, email, address, phone_number) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $address, $phone_number);
        return $stmt->execute();
    }
    // Get all accounts
    public function getAll() {
        $result = $this->conn->query("SELECT * FROM accounts");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    // Get account by ID
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM accounts WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    // Update account
    public function update($id, $name, $email, $address, $phone_number) {
        $stmt = $this->conn->prepare("UPDATE accounts SET name = ?, email = ?, address = ?, phone_number = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $name, $email, $address, $phone_number, $id);
        return $stmt->execute();
    }
    // Delete account
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM accounts WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
