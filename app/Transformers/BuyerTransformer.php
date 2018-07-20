<?php

namespace App\Transformers;

use App\Buyer;
use League\Fractal\TransformerAbstract;

class BuyerTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param Buyer $buyer
     * @return array
     */
    public function transform(Buyer $buyer)
    {
        return [
            'identifier' => (int)$buyer->id,
            'name'       => (string)$buyer->name,
            'mail'       => (string)$buyer->email,
            'isVerified' => (bool)$buyer->verified,
            'created_at' => (string)$buyer->created_at,
            'updated_at' => (string)$buyer->updated_at,
            'deleted_at' => isset($buyer->deleted_at) ? (string)$buyer->deleted_at : null,
            //HATEOAS
            'links'       => [
                [
                    'rel'  => 'self',
                    'href' => route('buyers.show', $buyer->id)
                ],[
                    'rel'  => 'buyers.categories',
                    'href' => route('buyers.categories.index', $buyer->id)
                ],
                [
                    'rel'  => 'buyers.products',
                    'href' => route('buyers.products.index', $buyer->id)
                ],
                [
                    'rel'  => 'buyers.sellers',
                    'href' => route('buyers.sellers.index', $buyer->id)
                ],
                [
                    'rel'  => 'buyers.transactions',
                    'href' => route('buyers.transactions.index', $buyer->id)
                ],
                [
                    'rel'  => 'user',
                    'href' => route('users.show', $buyer->id)
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
            'name'       => 'name',
            'mail'       => 'email',
            'isVerified' => 'verified',
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
            'name'       => 'name',
            'email'      => 'mail',
            'verified'   => 'isVerified',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
            'deleted_at' => 'deleted_at'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
