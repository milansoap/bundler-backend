<?php
include_once './models/User.php';
include_once './config/Database.php';
require __DIR__ . '../../vendor/autoload.php';

use DTO\Auth\LoginRequestDTO;
use \Firebase\JWT\JWT;


class AuthService {
    private $db;
    private $table_name = "users";

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function login($authRequest) {
        try {
            $email = $authRequest->getEmail();
            $password = $authRequest->getPassword();
            $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":email", $email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if (password_verify($password, $row['password'])) {
                    $key = "your_secret_key";
                    $payload = [
                        "id" => $row['id'],
                        "email" => $email,
                        "exp" => time() + (60 * 60)
                    ];
                    $jwt = JWT::encode($payload, $key, 'HS256');

                    return [
                        "status" => "OK",
                        "message" => "Login successful",
                        "access_token" => $jwt
                    ];
                } else {
                    return ["status" => "Error", "message" => "Invalid password"];
                }
            } else {
                return ["status" => "Error", "message" => "User not found"];
            }
        } catch (Exception $e) {
            return ["status" => "Error", "message" => $e->getMessage()];
        }
    }

    public function register($authRequest) {
        try {
            $email = $authRequest->getEmail();
            $password = $authRequest->getPassword();
            $query = "INSERT INTO " . $this->table_name . " (email, password) VALUES (:email, :password)";
            $stmt = $this->db->prepare($query);
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $hashedPassword);

            if ($stmt->execute()) {
                // Registration successful
                return $this->login($authRequest);
            } else {
                return ["status" => "Error", "message" => "Registration failed"];
            }
        } catch (Exception $e) {
            return ["status" => "Error", "message" => $e->getMessage()];
        }
    }
}
