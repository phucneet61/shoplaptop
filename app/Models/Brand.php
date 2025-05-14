<?php

namespace App\Models;

use App\Http\Controllers\BrandProduct;
use App\Http\Controllers\ProductController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'brand_name', 'brand_desc', 'meta_keywords', 'brand_status'
    ];
    protected $primaryKey = 'brand_id';
    protected $table = 'tbl_brand_product';
    
}
