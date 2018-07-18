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
            'deleted_at' => isset($user->deleted_at) ? (string)$user->deleted_at : null
        ];
    }
}
