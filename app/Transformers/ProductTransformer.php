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
            'title'       => (string)$product->title,
            'description' => (string)$product->description,
            'available'   => (int)$product->quantity,
            'status'      => (string)$product->status,
            'image'       => url("img/{$product->image}"),
            'vendedor'    => (int)$product->seller_id,
            'created_at'  => (string)$product->created_at,
            'updated_at'  => (string)$product->updated_at,
            'deleted_at'  => isset($product->deleted_at) ? (string)$product->deleted_at : null
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
            'title'       => 'title',
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
}
