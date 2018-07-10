<?php

namespace App;

class Seller extends User
{
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
