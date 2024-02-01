<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Classes\Eloquent\Domain\Model\BaseModel;
use App\Models\Catalogs\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends BaseModel
{
    use HasFactory, SoftDeletes;

    const TABLE = 'products';

    const NAME = 'name';
    const MODEL_YEAR = 'model_year';
    const PRICE = 'price';
    const STATUS = 'status';
    const CATEGORIES_ID = 'categories_id';

    protected $table = self::TABLE;
    public $timestamps = false;

    protected $fillable = array(
        self::NAME,
        self::MODEL_YEAR,
        self::PRICE,
        self::STATUS,
        self::CATEGORIES_ID,
    );

    public $with = [
        'category',
        'resource_product',
    ];

    public function category(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(
            Category::class,
            Category::ID,
            self::CATEGORIES_ID,
        );
    }

    public function resource_product(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(
            ResourceProduct::class,
            ResourceProduct::PRODUCTS_ID,
            self::ID,
        );
    }
}
