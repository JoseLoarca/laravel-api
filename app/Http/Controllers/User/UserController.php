<?php

namespace App\Http\Controllers\User;

use App\Mail\UserCreated;
use App\Transformers\UserTransformer;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Mail;

class UserController extends ApiController
{
    /**
     * UserController constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('client.credentials')->only(['store', 'resend']);
        $this->middleware('auth:api')->except(['store', 'verify', 'resend']);
        $this->middleware('transform.input:' . UserTransformer::class)->only(['store, update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = User::all();

        return $this->showAll($usuarios);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation_rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ];

        $this->validate($request, $validation_rules);

        $user_data = $request->all();
        $user_data['password'] = bcrypt($request->password);
        $user_data['verified'] = User::NO_VERIFICADO;
        $user_data['verification_token'] = User::genRandomToken();
        $user_data['admin'] = User::REGULAR;

        $usuario = User::create($user_data);

        return $this->showOne($usuario);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->showOne($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validation_rules = [
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'min:6|confirmed',
            'admin' => 'in:' . User::ADMIN . ',' . User::REGULAR
        ];

        $this->validate($request, $validation_rules);

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email') && $user->email != $request->email) {
            $user->verified = User::NO_VERIFICADO;
            $user->verification_token = User::genRandomToken();
            $user->email = $request->email;
        }

        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->has('admin')) {
            if (!$user->isVerificado()) {

                return $this->errorResponse('Únicamente los usuarios verificados pueden cambiar su rol de
                 administrador', 409);
            }

            $user->admin = $request->admin;
        }

        if (!$user->isDirty()) {

            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar', 422);
        }

        $user->save();

        return $this->showOne($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $user->delete();

        return $this->showOne($user);
    }

    /**
     * Procesa peticiones para verificar tokens de usuarios
     *
     * @param mixed $token Token de usuario
     *
     * @return \Illuminate\Http\Response
     */
    public function verify($token)
    {
        $user = User::where('verification_token', $token)->firstOrFail();

        $user->verified = User::VERIFICADO;
        $user->verification_token = null;

        $user->save();

        return $this->showMessage('La cuenta ha sido verificada');
    }

    /**
     * Procesa peticiones para re-enviar correos de verificacion
     *
     * @param User $user Instancia del usuario
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function resend(User $user)
    {
        if ($user->isVerificado())
        {
            return $this->errorResponse('Este usuario ya ha sido verificado.', 409);
        }

        retry(5, function () use ($user) {
            Mail::to($user)->send(new UserCreated($user));
        }, 100);

        return $this->showMessage('El correo ha sido reenviado.');
    }
}
