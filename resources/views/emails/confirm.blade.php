@component('mail::message')
    # Hola {{$user->name}}

    Tu email ha sido actualizado, por favor verifícalo usando el siguiente botón:

    @component('mail::button', ['url' => route('verify', $user->verification_token)])
        Verificar mi email
    @endcomponent

    Gracias,<br>
    {{ config('app.name') }}
@endcomponent
