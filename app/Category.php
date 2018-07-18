<?php

namespace App;

use App\Transformers\CategoryTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $fillable = array(
        'name',
        'description'
    );

    /**
     * @var string Category transformer
     */
    public $transformer = CategoryTransformer::class;

    /**
     * @var array
     */
    protected $hidden = [
        'pivot'
    ];

    /**
     * Relacion tabla Categorias -> Productos
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
