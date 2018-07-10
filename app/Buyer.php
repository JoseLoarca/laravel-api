<?php

namespace App;

class Buyer extends User
{
    /**
     * Relacion tabla Compradores -> Transacciones
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

}
