
<?php

class User extends Model
{
    // Find a user using their email address
    public function findByEmail($email)
    {
        $sql = "SELECT * FROM users
                WHERE email = :email
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':email' => $email
        ]);

        return $stmt->fetch();
    }

    // Find a user using their ID
    public function findById($id)
    {
        $sql = "SELECT * FROM users
                WHERE id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch();
    }

    // Create a new customer account
    public function create($name, $email, $phone, $password)
    {
        $sql = "INSERT INTO users
                (name, email, phone, password, role, status)
                VALUES
                (:name, :email, :phone, :password, 'customer', 'active')";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':password' => password_hash($password, PASSWORD_DEFAULT)
        ]);
    }

    // Check whether another user already uses this email
    public function emailExistsForOtherUser($email, $userId)
    {
        $sql = "SELECT id FROM users
                WHERE email = :email
                AND id != :user_id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':email' => $email,
            ':user_id' => $userId
        ]);

        return (bool) $stmt->fetch();
    }

    // Check whether another user already uses this phone number
    public function phoneExistsForOtherUser($phone, $userId)
    {
        $sql = "SELECT id FROM users
                WHERE phone = :phone
                AND id != :user_id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':phone' => $phone,
            ':user_id' => $userId
        ]);

        return (bool) $stmt->fetch();
    }

    // Update customer profile information
    public function updateProfile($userId, $name, $email, $phone)
    {
        $sql = "UPDATE users
                SET name = :name,
                    email = :email,
                    phone = :phone
                WHERE id = :user_id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':user_id' => $userId
        ]);
    }

    // Save the uploaded profile photo path
    public function updateProfileImage($userId, $imagePath)
    {
        $sql = "UPDATE users
                SET profile_image = :profile_image
                WHERE id = :user_id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':profile_image' => $imagePath,
            ':user_id' => $userId
        ]);
    }
}
