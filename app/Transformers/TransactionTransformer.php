<?php

namespace App\Transformers;

use App\Transaction;
use League\Fractal\TransformerAbstract;

class TransactionTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param Transaction $transaction
     * @return array
     */
    public function transform(Transaction $transaction)
    {
        return [
            'identifier' => (int)$transaction->id,
            'quantity'   => (int)$transaction->quantity,
            'buyer'      => (int)$transaction->buyer_id,
            'product'    => (int)$transaction->product_id,
            'created_at' => (string)$transaction->created_at,
            'updated_at' => (string)$transaction->updated_at,
            'deleted_at' => isset($transaction->deleted_at) ? (string)$transaction->deleted_at : null,
            //HATEOAS
            'links'       => [
                [
                    'rel'  => 'self',
                    'href' => route('transactions.show', $transaction->id)
                ],[
                    'rel'  => 'transaction.categories',
                    'href' => route('transactions.categories.index', $transaction->id)
                ],
                [
                    'rel'  => 'transaction.seller',
                    'href' => route('transactions.sellers.index', $transaction->id)
                ],
                [
                    'rel'  => 'buyer',
                    'href' => route('buyers.show', $transaction->buyer_id)
                ],
                [
                    'rel'  => 'product',
                    'href' => route('products.show', $transaction->product_id)
                ]
            ]
        ];
    }

    /**
     * @param $index
     * @return mixed|null
     */
    public static function originalAttribute($index)
    {
        $attributes =  [
            'identifier' => 'id',
            'quantity'   => 'quantity',
            'buyer'      => 'buyer_id',
            'product'    => 'product_id',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
            'deleted_at' => 'deleted_at'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    /**
     * @param $index
     * @return mixed|null
     */
    public static function transformedAttribute($index)
    {
        $attributes =  [
            'id'         => 'identifier',
            'quantity'   => 'quantity',
            'buyer_id'   => 'buyer',
            'product_id' => 'product',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
            'deleted_at' => 'deleted_at'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
