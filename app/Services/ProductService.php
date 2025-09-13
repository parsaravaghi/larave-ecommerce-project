<?php

namespace App\Services;

use App\Interfaces\Services\ProductServiceInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductService implements ProductServiceInterface
{
    public function __construct(
        private Product $product ,
    ){}

    public function findById(int $id): ?Product
    {
        return $this->product->find($id);
    }

    public function search(
        ?string $title , 
        ?string $description , 
        ?array $priceRange = [], 
        ?int $category = null, 
        int $part = 1, 
        int $limit = 10, 
        string $orderBy = 'id'
    ): Collection|null
    {
        
        // Get query builder
        $query = $this->product->query();

        // All requested products must be verified
        $query->where("is_verified" , '=' , true);

        // Use where with closure for proper grouping
        $query->where(function($q) use ($title, $description) {
            if($title) {
                $q->where("title", "like", "%{$title}%");
            }
            
            if($description) {
                $q->orWhere("description", "like", "%{$description}%");
            }
        });

        if(isset($priceRange['min']) && isset($priceRange['max'])) {
            $min = $priceRange['min'];
            $max = $priceRange['max'];
            $query->whereBetween("price", [$min, $max]);
        }

        if(isset($category)) {
            $query->where("category_id", "=", $category);
        }

        // Show requested value part by part
        $offset = ($part - 1) * $limit;
        
        return $query->orderBy($orderBy)
                    ->skip($offset)
                    ->limit($limit)
                    ->get();
    }

    public function createOne(array $userdata , int $user_id , bool $is_verified) : Product
    {
        // Merge userdata array with required data in an array
        $productData = [
            ...$userdata ,
            "user_id" => $user_id ,
            "is_verified" => $is_verified
        ];

        // Store the final array
        return $this->product->create($productData);
    }

    public function updateOne(array $userData , int $id): int
    {
        // Select the requested product and update it with user credntial
        return $this->product->find($id)
            ->update($userData);
    }

    public function deleteOne(int $id): int
    {
        // Delete query 
        return $this->product->where(["id" => $id])
            ->delete();
    }
}
