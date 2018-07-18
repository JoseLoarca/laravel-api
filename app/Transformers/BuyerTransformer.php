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
            'deleted_at' => isset($buyer->deleted_at) ? (string)$buyer->deleted_at : null
        ];
    }
}
