<?php

namespace App\Interfaces\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

interface CategoryServiceInterface
{
    public function findById(int $id) : ?Category;
    public function search(?string $name , int $part , int $limit) : ?Collection;
    public function createOne(array $userData) : ?Category;
    public function updateOne(array $userData , int $id) : int;
    public function deleteOne(int $id) : int;
    public function getParents(int $id) : ?array;
}
