<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Classes\Eloquent\Domain\Model\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends BaseModel
{
    use HasFactory, SoftDeletes;

    const TABLE = 'categories';

    const NAME = 'name';
    const DESC = 'desc';

    protected $table = self::TABLE;
    public $timestamps = false;

    protected $fillable = array(
        self::NAME,
        self::DESC,
    );
}
