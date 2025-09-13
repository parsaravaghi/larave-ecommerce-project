<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";
    
    protected $fillable = [
        "title" , 
        "description" , 
        "image_url" ,
        "price" ,
        "products_count" ,
        "sales_count" ,
        "is_verified" ,
        "category_id" ,
        "user_id"
    ];
}
