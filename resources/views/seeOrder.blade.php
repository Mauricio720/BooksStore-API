@extends('adminlte::page')

@section('content')
    <div class="content-header">
        <div class="card">
            <div class="card-header">
                <div class="w-100">
                    <h3> Detalhes do pedido - {{ $order->id }}</h3> <span
                        class="badge {{ $badgesArray[$order->status] }}">
                        {{ $statusTranslators[$order->status] }} </span>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex w-100">
        <div class="card w-50">
            <div class="card-body">
                <div class="form-group">
                    <label>Subtotal</label>
                    <div class="form-control">R$ {{ number_format($order->subtotal, 2, ',', '.') }}</div>
                </div>
                <div class="form-group">
                    <label>Total</label>
                    <div class="form-control">R$ {{ number_format($order->subtotal, 2, ',', '.') }}</div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>Informação Cliente</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nome</label>
                            <div class="form-control">{{ $order['user']->name }}</div>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <div class="form-control">{{ $order['user']->email }}</div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4>Endereço Cliente</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Rua</label>
                            <div class="form-control">{{ $order['user']['address']->street }}</div>
                        </div>
                        <div class="form-group">
                            <label>Numero</label>
                            <div class="form-control">{{ $order['user']['address']->number }}</div>
                        </div>

                        <div class="form-group">
                            <label>Bairro</label>
                            <div class="form-control">{{ $order['user']['address']->neighborhood }}</div>
                        </div>

                        <div class="form-group">
                            <label>Cidade</label>
                            <div class="form-control">{{ $order['user']['address']->city }}</div>
                        </div>

                        <div class="form-group">
                            <label>Cep</label>
                            <div class="form-control">{{ $order['user']['address']->cep }}</div>
                        </div>

                        <div class="form-group">
                            <label>Estado</label>
                            <div class="form-control">{{ $order['user']['address']->state }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card w-50">
            <div class="card-header">
                <h4>Items Compra</h4>
            </div>
            <div class="card-body">
                @foreach ($orderItems as $item)
                    <div class="buyItem">
                        <div class="preview">
                            <img src="{{ $item->img }}" alt="preview">
                        </div>
                        <div class="buyItem__content">
                            <h4>{{ $item->title }}</h4>
                            <span class="buyItem__description">{{ $item->description }}</span>
                            <span>quantidade: {{ $item->quantity }}</span>
                            <span>preço unitário: R$ {{ number_format($order->unit_price, 2, ',', '.') }}</span>
                            <span>total: R$ {{ number_format($order->total_price, 2, ',', '.') }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
