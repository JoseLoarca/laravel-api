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
}
