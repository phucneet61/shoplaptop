<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProductModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'category_name', 'category_desc', 'meta_keywords', 'category_status', 'category_parent'
    ];
    protected $primaryKey = 'category_id';
    protected $table = 'tbl_category_product';
}
