<?php

namespace App\Services;

use App\Interfaces\Services\CategoryServiceInterface;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryService implements CategoryServiceInterface
{
    public function __construct(
        private Category $category 
    ) {}

    public function findById(int $id): ?Category
    {
        // find category by requested id
        return $this->category->find($id);
    }

    public function search(?string $name, int $part, int $limit): ?Collection
    {
        $query = $this->category->query();

        if($name)
            $query->where("name" , "like" , "%{$name}%");

        return $query->skip(($part - 1) * $limit)
                ->limit($limit)
                ->get();
    }

    public function createOne(array $userData): ?Category
    {
        // Recorde a new category by admin credentials
        return $this->category->create($userData);
    }

    public function updateOne(array $userData , int $id): int
    {
        // Update category by requested id
        return $this->category->find($id)
            ->update($userData);
    }

    public function deleteOne(int $id): int
    {
        // Delete category by requested id
        return $this->category->find($id)
            ->delete(); 
    }

    public function getParents(int $id): ?array
    {
        return $this->category->fetchParents($id);
    }
}
