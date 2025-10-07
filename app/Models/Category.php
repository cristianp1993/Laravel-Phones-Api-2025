<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Category extends Model
{
    use HasFactory;
     protected $fillable = [
        'name',
        'slug',
        'description',
        'estado',
        'position',
    ];

    protected $casts = [
        'estado' => 'boolean',
    ];
    public function phones()
    {
        return $this->hasMany(Phone::class); // FK por convención: phones.category_id
    }
}
