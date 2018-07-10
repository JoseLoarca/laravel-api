<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * @var string DISPONIBLE Indica estado 'disponible'
     */
    const DISPONIBLE = 'disponible';

    /**
     * @var string NO_DISPONIBLE Indica estado 'no disponible'
     */
    const NO_DISPONIBLE = 'no disponible';

    /**
     * @var array
     */
    protected $fillable = array(
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller_id'
    );

    /**
     * Verifica si un producto esta disponible
     */
    public function isDisponible()
    {
        return $this->status == Product::DISPONIBLE;
    }

    /**
     * Relacion tabla Productos -> Vendedores
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    /**
     * Relacion tabla Productos -> Transacciones
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    
    /**
     * Relacion tabla Productos -> Categorias
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
