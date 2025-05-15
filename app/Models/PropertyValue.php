<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyValue extends Model
{
    protected $table = 'property_values';

    protected $fillable = [
        'value'
    ];

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function property(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
