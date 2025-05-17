<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPropertyValue extends Model
{
    use HasFactory;

    protected $table = 'product_property_value';

    protected $fillable = ['value'];

    protected $dateFormat = 'Y-m-d H:i:s';

    protected function product()
    {
        return $this->belongsTo(Product::class);
    }
}
