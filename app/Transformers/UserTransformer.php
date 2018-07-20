<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param User $user
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'identifier' => (int)$user->id,
            'name'       => (string)$user->name,
            'mail'       => (string)$user->email,
            'isVerified' => (bool)$user->verified,
            'isAdmin'    => (bool)$user->admin,
            'created_at' => (string)$user->created_at,
            'updated_at' => (string)$user->updated_at,
            'deleted_at' => isset($user->deleted_at) ? (string)$user->deleted_at : null,
            //HATEOAS
            //HATEOAS
            'links'       => [
                [
                    'rel'  => 'self',
                    'href' => route('users.show', $user->id)
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
            'isAdmin'    => 'admin',
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
            'admin'      => 'isAdmin',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
            'deleted_at' => 'deleted_at'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
