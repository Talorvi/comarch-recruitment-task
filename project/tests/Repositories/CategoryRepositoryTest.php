<?php

namespace Repositories;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use mysqli;
use mysqli_result;
use PHPUnit\Framework\TestCase;

class CategoryRepositoryTest extends TestCase
{
    private $conn;

    protected function setUp(): void
    {
        $this->conn = $this->createMock(mysqli::class);
    }

    public function testGetAllCategoriesReturnsArrayOfCategories()
    {
        $result = $this->createMock(mysqli_result::class);
        $categoryData = [
            ['id' => 1, 'category_name' => 'Technology'],
            ['id' => 2, 'category_name' => 'Health']
        ];

        $result->method('fetch_assoc')
            ->willReturnOnConsecutiveCalls($categoryData[0], $categoryData[1], null);

        $this->conn->method('query')
            ->willReturn($result);

        $categories = CategoryRepository::getAllCategories($this->conn);

        $this->assertCount(2, $categories);
        $this->assertInstanceOf(Category::class, $categories[0]);
        $this->assertEquals('Technology', $categories[0]->getName());
    }

    public function testGetAllCategoriesReturnsEmptyArrayWhenNoCategories()
    {
        $result = $this->createMock(mysqli_result::class);
        $result->method('fetch_assoc')->willReturn(null);

        $this->conn->method('query')->willReturn($result);

        $categories = CategoryRepository::getAllCategories($this->conn);

        $this->assertEmpty($categories);
    }
}
