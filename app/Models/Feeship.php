<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feeship extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'fee_matp', 'fee_maqh', 'fee_xaid', 'fee_feeship'
    ];
    protected $primaryKey = 'fee_id';
    protected $table = 'tbl_feeship';

    // public function city(){
    //     return $this->belongsTo('App\Models\City', 'fee_matp');
    // }
    // public function province(){
    //     return $this->belongsTo('App\Models\Province', 'fee_maqh');
    // }
    // public function ward(){
    //     return $this->belongsTo('App\Models\Wards', 'fee_xaid');
    // }

    public function city(){
        return $this->belongsTo(City::class, 'fee_matp', 'matp');
    }
    public function province(){
        return $this->belongsTo(Province::class,'fee_maqh','maqh');
    }
    public function wards(){
        return $this->belongsTo(Wards::class,'fee_xaid','xaid');
    }
    
}
