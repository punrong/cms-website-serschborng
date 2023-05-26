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
        'created_by',
        'updated_by'
    ];

    public static function getCategoryList(){
        return Category::where('status', 'ACT')->orderBy('id', 'asc')->pluck('name', 'id');
    }

    public static function getCategoryArray(){
        return Category::select('id', 'name')->where('status', 'ACT')->orderBy('id', 'asc')->get()->toArray();
    }

    public static function getCategoryName($category_id){
        return Category::where('id', $category_id)->where('status', 'ACT')->value('name');
    }

    public static function getCategoryNameList(){
        return Category::where('status', 'ACT')->orderBy('id', 'asc')->pluck('name');
    }
}
