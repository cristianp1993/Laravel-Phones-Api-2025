<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'country_code',
        'area_code',
        'type',
        'is_primary',
        'extension',
        'notes',
        'category_id',
        'barcode',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

     public function category()
    {
        return $this->belongsTo(Category::class); 
    }
}
