
<?php

class Category extends Model
{
    // Get all active main categories
    public function getMainCategories()
    {
        $sql = "SELECT id, name
                FROM categories
                WHERE parent_id IS NULL
                AND status = 'active'
                ORDER BY sort_order ASC, name ASC";

        $stmt = $this->db->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll();
    }


    // Get active subcategories of a selected main category
    public function getSubcategories($parentId)
    {
        $sql = "SELECT id, name
                FROM categories
                WHERE parent_id = :parent_id
                AND status = 'active'
                ORDER BY sort_order ASC, name ASC";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':parent_id' => $parentId
        ]);

        return $stmt->fetchAll();
    }


    // Check whether a subcategory belongs to a main category
    public function subcategoryBelongsToParent($subcategoryId, $parentId)
    {
        $sql = "SELECT id
                FROM categories
                WHERE id = :subcategory_id
                AND parent_id = :parent_id
                AND status = 'active'
                LIMIT 1";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':subcategory_id' => $subcategoryId,
            ':parent_id' => $parentId
        ]);

        return (bool) $stmt->fetch();
    }
}
