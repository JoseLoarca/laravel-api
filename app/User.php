<?php

namespace App;

use App\Transformers\UserTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasApiTokens;

    /**
     * @var int VERIFICADO Indica estado 'verificado' del usuario
     */
    const VERIFICADO = 1;

    /**
     * @var int NO_VERIFICADO Indica estado 'no verificado' del usuario
     */
    const NO_VERIFICADO = 0;

    /**
     * @var int ADMIN Indica rol 'administrador' del usuario
     */
    const ADMIN = 1;

    /**
     * @var int REGULAR Indica rol 'usuario regular' del usuario
     */
    const REGULAR = 0;

    /**
     * @var string $table Nombre tabla usuarios
     */
    protected $table = 'users';

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verified',
        'verification_token',
        'admin'
    ];

    /**
     * @var string User transformer
     */
    public $transformer = UserTransformer::class;

    /**
     * @param $value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }

    /**
     * @param $value
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    /**
     * @param $value
     * @return string
     */
    public function getNameAttribute($value)
    {
        return ucwords($value);
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token'
    ];

    /**
     * Verifica si un usuario esta verificado
     *
     * @return bool
     */
    public function isVerificado()
    {
        return $this->verified == User::VERIFICADO;
    }

    /**
     * Verifica si un usuario es administrador
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->admin == User::ADMIN;
    }

    /**
     * Genera un token random para verificar
     *
     * @return string
     */
    public static function genRandomToken()
    {
        return str_random(40);
    }
}
