
<?php

class Service extends Model
{
    // Get services belonging to a main category
    public function getServicesByMainCategory($categoryId)
    {
        $sql = "SELECT
                    s.id,
                    s.title,
                    s.slug,
                    s.description,
                    s.price,
                    s.price_type,
                    s.service_image,
                    s.created_at,

                    subcategory.name AS subcategory_name,

                    provider.id AS provider_id,
                    provider.business_name,
                    provider.city,
                    provider.state,

                    users.name AS provider_name,

                    -- Average rating for this service
                    (
                        SELECT ROUND(AVG(r.rating), 1)
                        FROM reviews r
                        WHERE r.service_id = s.id
                        AND r.status = 'published'
                    ) AS average_rating,

                    -- Total published reviews for this service
                    (
                        SELECT COUNT(*)
                        FROM reviews r
                        WHERE r.service_id = s.id
                        AND r.status = 'published'
                    ) AS review_count

                FROM services s

                INNER JOIN categories subcategory
                    ON s.category_id = subcategory.id

                INNER JOIN categories main_category
                    ON subcategory.parent_id = main_category.id

                INNER JOIN provider_profiles provider
                    ON s.provider_id = provider.id

                INNER JOIN users
                    ON provider.user_id = users.id

                WHERE main_category.id = :category_id
                AND main_category.status = 'active'
                AND subcategory.status = 'active'
                AND s.status = 'active'
                AND provider.status = 'active'
                AND users.status = 'active'

                ORDER BY s.created_at DESC";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':category_id' => $categoryId
        ]);

        return $stmt->fetchAll();
    }


    // Find one active service with its provider details
    public function findActiveById($serviceId)
    {
        $sql = "SELECT
                    s.id,
                    s.title,
                    s.slug,
                    s.description,
                    s.price,
                    s.price_type,
                    s.service_image,
                    s.created_at,

                    subcategory.id AS subcategory_id,
                    subcategory.name AS subcategory_name,

                    main_category.id AS main_category_id,
                    main_category.name AS main_category_name,

                    provider.id AS provider_id,
                    provider.business_name,
                    provider.description AS provider_description,
                    provider.profile_image AS provider_image,
                    provider.address AS provider_address,
                    provider.city AS provider_city,
                    provider.state AS provider_state,
                    provider.pincode AS provider_pincode,

                    users.id AS provider_user_id,
                    users.name AS provider_name,
                    users.email AS provider_email,
                    users.phone AS provider_phone

                FROM services s

                INNER JOIN categories subcategory
                    ON s.category_id = subcategory.id

                INNER JOIN categories main_category
                    ON subcategory.parent_id = main_category.id

                INNER JOIN provider_profiles provider
                    ON s.provider_id = provider.id

                INNER JOIN users
                    ON provider.user_id = users.id

                WHERE s.id = :service_id
                AND s.status = 'active'
                AND subcategory.status = 'active'
                AND main_category.status = 'active'
                AND provider.status = 'active'
                AND users.status = 'active'

                LIMIT 1";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':service_id' => $serviceId
        ]);

        return $stmt->fetch();
    }


    // Get all services belonging to one provider
    public function getServicesByProvider($providerId)
    {
        $sql = "SELECT
                    s.id,
                    s.title,
                    s.slug,
                    s.description,
                    s.price,
                    s.price_type,
                    s.service_image,
                    s.status,
                    s.created_at,

                    subcategory.name AS subcategory_name,
                    main_category.name AS main_category_name

                FROM services s

                LEFT JOIN categories subcategory
                    ON s.category_id = subcategory.id

                LEFT JOIN categories main_category
                    ON subcategory.parent_id = main_category.id

                WHERE s.provider_id = :provider_id

                ORDER BY s.created_at DESC";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':provider_id' => $providerId
        ]);

        return $stmt->fetchAll();
    }


    // Create a new service
    public function create(
        $providerId,
        $categoryId,
        $title,
        $slug,
        $description,
        $price,
        $priceType,
        $serviceImage
    ) {
        $sql = "INSERT INTO services
                (
                    provider_id,
                    category_id,
                    title,
                    slug,
                    description,
                    price,
                    price_type,
                    service_image,
                    status
                )
                VALUES
                (
                    :provider_id,
                    :category_id,
                    :title,
                    :slug,
                    :description,
                    :price,
                    :price_type,
                    :service_image,
                    'active'
                )";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':provider_id' => $providerId,
            ':category_id' => $categoryId,
            ':title' => $title,
            ':slug' => $slug,
            ':description' => $description,
            ':price' => $price,
            ':price_type' => $priceType,
            ':service_image' => $serviceImage
        ]);
    }
}
