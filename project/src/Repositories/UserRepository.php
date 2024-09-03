<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public static function getUsersByCategory($categoryId, $conn): array
    {
        $sql = "SELECT u.id, u.first_name, u.last_name, u.email FROM users u 
                JOIN user_categories uc ON u.id = uc.user_id 
                WHERE uc.category_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();
        $result = $stmt->get_result();

        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = new User($row['id'], $row['first_name'], $row['last_name'], $row['email']);
        }
        return $users;
    }
}
