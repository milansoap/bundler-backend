<?php
include_once './models/User.php';
include_once './config/Database.php';

use \Firebase\JWT\JWT;

class UserService {
    private $db;
    private $table_name = "users";

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    /**
     * @return User[]
     */
    public function getAllUsers(): array {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $users = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $user = new User($row['id'], $row['email'], $row['password'], $row['created_at'], $row['updated_at']);
            array_push($users, $user);
        }

        return $users;
    }

    /**
     * @return User
     */
    public function getUserById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return [
                'id' => $result['id'],
                'email' => $result['email'],
                'password' => $result['password'],
                'created_at' => $result['created_at'],
                'updated_at' => $result['updated_at']
            ];
        } else {
            return null;
        }
    }

    public function getUserByToken($token) {
        list($header, $payload, $signature) = explode('.', $token);

        $decoded_payload = base64_decode($payload);
        $decoded_array = json_decode($decoded_payload, true);

        if ($decoded_array && array_key_exists('id', $decoded_array)) {
            $userId = $decoded_array['id'];
            $email = $decoded_array['email'];

            http_response_code(200);
            echo json_encode(['success' => true, 'user' => ['id' => $userId, 'email' => $email]]);
        } else {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Invalid token']);
        }
    }

    public function createUser($data) {
        $query = "INSERT INTO " .
            $this->table_name . " (email, password, name, surname, failed_attempts, is_locked, created_at, updated_at) VALUES (:email, :password, :name, :surname, :failed_attempts, :is_locked, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
        $stmt = $this->db->prepare($query);

        // Bind parameters
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':surname', $data['surname']);
        $stmt->bindParam(':failed_attempts', $data['failed_attempts']);
        $stmt->bindParam(':is_locked', $data['is_locked']);

        if ($stmt->execute()) {
            return ['status' => 'success', 'message' => 'User created'];
        } else {
            return ['status' => 'error', 'message' => 'User creation failed'];
        }
    }

    public function updateUser($id, $data) {
        $query = "UPDATE " . $this->table_name . " SET email = :email, password = :password, name = :name, surname = :surname, failed_attempts = :failed_attempts, is_locked = :is_locked, updated_at = CURRENT_TIMESTAMP WHERE id = :id";
        $stmt = $this->db->prepare($query);

        // Bind parameters
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':surname', $data['surname']);
        $stmt->bindParam(':failed_attempts', $data['failed_attempts']);
        $stmt->bindParam(':is_locked', $data['is_locked']);

        if ($stmt->execute()) {
            return ['status' => 'success', 'message' => 'User updated'];
        } else {
            return ['status' => 'error', 'message' => 'User update failed'];
        }
    }

    public function deleteUser($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->db->prepare($query);

        // Bind parameter
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return ['status' => 'success', 'message' => 'User deleted'];
        } else {
            return ['status' => 'error', 'message' => 'User deletion failed'];
        }
    }
}
