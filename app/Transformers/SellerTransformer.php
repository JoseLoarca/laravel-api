<?php

namespace App\Transformers;

use App\Seller;
use League\Fractal\TransformerAbstract;

class SellerTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param Seller $seller
     * @return array
     */
    public function transform(Seller $seller)
    {
        return [
            'identifier' => (int)$seller->id,
            'name'       => (string)$seller->name,
            'mail'       => (string)$seller->email,
            'isVerified' => (bool)$seller->verified,
            'created_at' => (string)$seller->created_at,
            'updated_at' => (string)$seller->updated_at,
            'deleted_at' => isset($seller->deleted_at) ? (string)$seller->deleted_at : null
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
            'name'       => 'name',
            'mail'       => 'email',
            'isVerified' => 'verified',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
            'deleted_at' => 'deleted_at'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
