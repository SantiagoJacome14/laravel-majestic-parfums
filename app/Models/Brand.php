<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    /**
     * Tabla asociada
     */
    protected $table = 'brands';

    /**
     * Campos asignables
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Relación: una marca tiene muchos productos
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}