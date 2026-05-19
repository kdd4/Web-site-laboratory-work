<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

use function is_resource;

class Blog extends Model
{
    protected $hidden = ['image'];

    protected function image(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if (is_resource($value)) {
                    rewind($value);
                    return stream_get_contents($value);
                }
                
                // pdo_pgsql возвращает bytea в hex-формате: '\x89504e47...'
                if (is_string($value) && str_starts_with($value, '\\x')) {
                    return hex2bin(substr($value, 2));
                }

                return $value;
            },
        );
    }
}
