<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';

    protected $fillable = [
        'name',
        'price',
        'quant',
    ];

    protected $dateFormat = 'Y-m-d H:i:s';

    protected function productPropertyValues()
    {
        return $this->hasMany(ProductPropertyValue::class);
    }

}
