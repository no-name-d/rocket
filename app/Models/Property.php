<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $table = 'property';

    protected $fillable = [
      'name'
    ];

    public function propertyValues()
    {
        return $this->hasMany(PropertyValue::class);
    }

    protected $dateFormat = 'Y-m-d H:i:s';
}
