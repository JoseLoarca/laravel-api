<?php

namespace App\Transformers;

use App\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param Product $product
     * @return array
     */
    public function transform(Product $product)
    {
        return [
            'identifier'  => (int)$product->id,
            'name'        => (string)$product->name,
            'description' => (string)$product->description,
            'available'   => (int)$product->quantity,
            'status'      => (string)$product->status,
            'image'       => url("img/{$product->image}"),
            'vendedor'    => (int)$product->seller_id,
            'created_at'  => (string)$product->created_at,
            'updated_at'  => (string)$product->updated_at,
            'deleted_at'  => isset($product->deleted_at) ? (string)$product->deleted_at : null,
            //HATEOAS
            'links'       => [
                [
                    'rel'  => 'self',
                    'href' => route('products.show', $product->id)
                ],
                [
                    'rel'  => 'product.buyers',
                    'href' => route('products.buyers.index', $product->id)
                ],
                [
                    'rel'  => 'product.categories',
                    'href' => route('products.categories.index', $product->id)
                ],
                [
                    'rel'  => 'product.transactions',
                    'href' => route('products.transactions.index', $product->id)
                ],
                [
                    'rel'  => 'seller',
                    'href' => route('sellers.show', $product->seller_id)
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
            'identifier'  => 'id',
            'name'        => 'name',
            'description' => 'description',
            'available'   => 'quantity',
            'status'      => 'status',
            'image'       => 'image',
            'vendedor'    => 'seller_id',
            'created_at'  => 'created_at',
            'updated_at'  => 'updated_at',
            'deleted_at'  => 'deleted_at'
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
            'id'          => 'identifier',
            'name'        => 'name',
            'description' => 'description',
            'quantity'    => 'available',
            'status'      => 'status',
            'image'       => 'image',
            'seller_id'   => 'vendedor',
            'created_at'  => 'created_at',
            'updated_at'  => 'updated_at',
            'deleted_at'  => 'deleted_at'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
