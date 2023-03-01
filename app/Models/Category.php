<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    public static function getCategoryList(){
        return Category::where('status', 'ACT')->orderBy('id', 'asc')->pluck('name', 'id');
    }

    public static function getCategoryName($category_id){
        return Category::where('id', $category_id)->where('status', 'ACT')->value('name');
    }
}
