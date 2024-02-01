<?php

namespace App\Models;

use App\Models\Catalogs\CatResourceType;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Classes\Eloquent\Domain\Model\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Resource extends BaseModel
{
    use HasFactory, SoftDeletes;

    const TABLE = 'resources';

    const NAME = 'name';
    const URL = 'url';
    const CAT_RESOURCE_TYPES_ID = 'cat_resource_types_id';

    protected $table = self::TABLE;
    public $timestamps = false;

    protected $fillable = array(
        self::NAME,
        self::URL,
        self::CAT_RESOURCE_TYPES_ID,
    );

    public $with = [
        'cat_resource_types',
    ];

    public function cat_resource_types(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(
            CatResourceType::class,
            CatResourceType::ID,
            self::CAT_RESOURCE_TYPES_ID,
        );
    }
}
