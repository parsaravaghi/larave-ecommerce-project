<?php

namespace App\Interfaces\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

interface ProductServiceInterface
{
    public function findById(int $id) : ?Product;
    public function search(?string $title , ?string $description , ?array $priceRange , ?int $category , int $part, int $limit , string $orderBy) : ?Collection;
    public function createOne(array $userData , int $user_id , bool $is_verified) : Product;
    public function updateOne(array $userData , int $id) : int;
    public function deleteOne(int $id) : int;
}