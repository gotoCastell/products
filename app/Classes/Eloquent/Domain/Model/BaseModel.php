<?php

namespace App\Classes\Eloquent\Domain\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Base Model
 * Common fields
 */
class BaseModel extends Model
{
    const ID = 'id';
    const CREATED_AT = 'created_at';
    const DELETED_AT = 'deleted_at';
    const UPDATED_AT = 'updated_at';


    protected $casts = [
        self::CREATED_AT => 'datetime',
        self::DELETED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        self::ID => 'integer',
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

}
