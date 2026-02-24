<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * Tabla asociada (opcional, Laravel la detecta)
     */
    protected $table = 'products';

    /**
     * Campos permitidos para asignación masiva
     */
    protected $fillable = [
        'brand_id',
        'name',
        'slug',
        'category',
        'gender',
        'size',
        'concentration',
        'tag',
        'price',
        'supplier_price',
        'image',
        'images',
        'stock',
        'is_new',
        'is_active'
    ];

    /**
     * Conversión automática de tipos
     */
    protected $casts = [
        'images' => 'array',
        'is_new' => 'boolean',
        'is_active' => 'boolean',
        'price' => 'integer',
        'supplier_price' => 'integer',
        'stock' => 'integer',
    ];

    /**
     * Relación: un producto pertenece a una marca
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}