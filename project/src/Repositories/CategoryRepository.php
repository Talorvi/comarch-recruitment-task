<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    public static function getAllCategories($conn): array
    {
        $categories = [];
        $sql = "SELECT id, category_name FROM categories";
        $result = $conn->query($sql);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $categories[] = new Category($row['id'], $row['category_name']);
            }
        }

        return $categories;
    }
}
