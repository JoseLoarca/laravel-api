<?php

namespace App;

use App\Scopes\SellerScope;
use App\Transformers\SellerTransformer;

class Seller extends User
{
    /**
     * @var string Seller transformer
     */
    public $transformer = SellerTransformer::class;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new SellerScope);
    }

    /**
     * Relacion tabla Vendedores -> Productos
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
