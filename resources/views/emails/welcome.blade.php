@component('mail::message')
    # Hola {{$user->name}}

    Gracias por crear una cuenta. Por favor verifica tu email usando el siguiente botón:

    @component('mail::button', ['url' => route('verify', $user->verification_token)])
        Verificar mi email
    @endcomponent

    Gracias,<br>
    {{ config('app.name') }}
@endcomponent
