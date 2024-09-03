<?php

namespace Repositories;

use App\Models\User;
use App\Repositories\UserRepository;
use mysqli;
use mysqli_result;
use mysqli_stmt;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{
    private $conn;
    private $stmt;
    private $result;

    protected function setUp(): void
    {
        // Mocking the mysqli object
        $this->conn = $this->createMock(mysqli::class);
        $this->stmt = $this->createMock(mysqli_stmt::class);
        $this->result = $this->createMock(mysqli_result::class);

        // Set up the connection behavior
        $this->conn->method('prepare')->willReturn($this->stmt);
        $this->stmt->method('execute')->willReturn(true);
        $this->stmt->method('get_result')->willReturn($this->result);
    }

    public function testGetUsersByCategoryReturnsArrayOfUsers()
    {
        $userData = [
            ['id' => 1, 'first_name' => 'John', 'last_name' => 'Doe', 'email' => 'john.doe@example.com'],
            ['id' => 2, 'first_name' => 'Jane', 'last_name' => 'Smith', 'email' => 'jane.smith@example.com']
        ];

        $this->result->method('fetch_assoc')
            ->willReturnOnConsecutiveCalls($userData[0], $userData[1], null);

        $users = UserRepository::getUsersByCategory(1, $this->conn);

        $this->assertCount(2, $users);
        $this->assertInstanceOf(User::class, $users[0]);
        $this->assertEquals('John', $users[0]->getFirstName());
    }

    public function testGetUsersByCategoryReturnsEmptyArrayWhenNoUsers()
    {
        $this->result->method('fetch_assoc')->willReturn(null);

        $users = UserRepository::getUsersByCategory(1, $this->conn);

        $this->assertEmpty($users);
    }
}
