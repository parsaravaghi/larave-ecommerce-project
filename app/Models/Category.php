<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";

    protected $fillable = [
        'name' , 
        'description' , 
        'image_url' ,
        "parent_id"
    ];

    public function fetchParents(int $id) : ?array
    {
        $query = "
            WITH RECURSIVE Parentcategory AS (
                SELECT id, name, parent_id 
                FROM categories 
                WHERE id = ?
                
                UNION ALL
                
                SELECT t.id, t.name, t.parent_id
                FROM categories t
                INNER JOIN Parentcategory pc ON pc.parent_id = t.id
            )
            SELECT * FROM Parentcategory
        ";
        return DB::select($query , [$id]);
    }
}
