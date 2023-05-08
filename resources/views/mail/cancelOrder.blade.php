@component('mail::message')
    <h1>Pedido Cancelado</h1>
    <p>
        Olá {{ $user->name }}, seu pedido foi cancelado. Entre em contato para mais informações.

    </p>
@endcomponent
