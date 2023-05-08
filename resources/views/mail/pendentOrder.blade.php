@component('mail::message')
    <h1>Pedido Registrado</h1>
    <p>
        Olá {{ $user->name }}, seu pedido foi registrado e está aguardando o pagamento.
        Para fazer o pagamento, basta clicar nesse <a href="{{ $order->link_payment }}">Link</a>.
        Ou copie esse link no seu navegador: {{ $order->link_payment }}
    </p>
@endcomponent
