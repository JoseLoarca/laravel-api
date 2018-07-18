<?php

namespace App;

use App\Transformers\TransactionTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $fillable = array(
        'quantity',
        'buyer_id',
        'product_id'
    );

    /**
     * @var string Transaction transformer
     */
    public $transformer = TransactionTransformer::class;

    /**
     * Relacion tabla Transacciones -> Compradores
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function buyer()
    {
        return $this->belongsTo(Buyer::class);
    }

    /**
     * Relacion tabla Transacciones -> Productos
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
