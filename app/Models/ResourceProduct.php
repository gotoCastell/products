<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Classes\Eloquent\Domain\Model\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResourceProduct extends BaseModel
{
    use HasFactory, SoftDeletes;

    const TABLE = 'resource_products';

    const PRODUCTS_ID = 'products_id';
    const RESOURCES_ID = 'resources_id';

    protected $table = self::TABLE;
    public $timestamps = false;

    protected $fillable = array(
        self::PRODUCTS_ID,
        self::RESOURCES_ID,
    );

    public function resource(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(
            Resource::class,
            Resource::ID,
            self::ID,
        );
    }
}
