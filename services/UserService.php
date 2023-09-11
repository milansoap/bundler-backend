<?php
include_once './models/User.php';
include_once './config/Database.php';


class UserService {
    private $userModel;
    private $db;
    private $table_name = "users";

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function getAllUsers() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $users = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $user = [
                'id' => $row['id'],
                'email' => $row['email'],
                'password' => $row['password'],
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at']
            ];
            array_push($users, $user);
        }

        return $users;
    }

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
}
