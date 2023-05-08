@component('mail::message')
    <h1>Pedido Concluido</h1>
    <p>
        Olá {{ $user->name }}, o pagamento do seu pedido foi registrado. Aguarde a entrega do seu pedido.
    </p>
@endcomponent
