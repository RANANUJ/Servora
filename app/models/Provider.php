
<?php

class Provider extends Model
{
    // Find provider profile using user ID
    public function findByUserId($userId)
    {
        $sql = "SELECT *
                FROM provider_profiles
                WHERE user_id = :user_id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':user_id' => $userId
        ]);

        return $stmt->fetch();
    }


    // Create a new provider profile
    public function create(
        $userId,
        $categoryId,
        $businessName,
        $description,
        $address,
        $city,
        $state,
        $pincode
    ) {
        $sql = "INSERT INTO provider_profiles
                (
                    user_id,
                    category_id,
                    business_name,
                    description,
                    address,
                    city,
                    state,
                    pincode,
                    status
                )
                VALUES
                (
                    :user_id,
                    :category_id,
                    :business_name,
                    :description,
                    :address,
                    :city,
                    :state,
                    :pincode,
                    'active'
                )";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':user_id' => $userId,
            ':category_id' => $categoryId,
            ':business_name' => $businessName,
            ':description' => $description,
            ':address' => $address,
            ':city' => $city,
            ':state' => $state,
            ':pincode' => $pincode
        ]);
    }
}
