<?php

include 'BaseModel.php';

class Login extends BaseModel {
    public function authenticate($username, $password) {
        $query = "SELECT * FROM users WHERE username = :username AND password = :password";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
?>
