@extends('adminlte::page')

@section('content')
    <div class="container">
        <div class="card-header w-100">
            <h4>Pedidos</h4>
        </div>
        <div class="card-header w-100">
            <form method="get">
                <div class="form-group w-50">
                    <input class="form-control" value="{{ $search }}" name="search"
                        placeholder="Digite o nome ou email do cliente">
                </div>
                <div class="form-group w-50">
                    <input class="form-control" value="{{ $date }}" type="date" name="date" type="text">
                </div>

                <div class="form-group w-50">
                    <select class="form-control" name="status">
                        <option value="">Selecione o status</option>
                        <option value="pendent" {{ $status === 'pendent' ? 'selected' : '' }}>Pendente</option>
                        <option value="success" {{ $status === 'success' ? 'selected' : '' }}>Finalizado</option>
                        <option value="cancel" {{ $status === 'cancel' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                </div>
                <div class="form-group w-50">
                    <input class="btn btn-success w-100" type="submit" value="Pesquisar">
                </div>
            </form>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Id</th>
                        <th>Subtotal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Data</th>
                        <th>Nome Cliente</th>
                        <th>Email Cliente</th>
                        <th>Acões</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ number_format($order->subtotal, 2, ',', '.') }} R$</td>
                            <td>{{ number_format($order->total, 2, ',', '.') }} R$</td>
                            <td>
                                <span class="badge {{ $badgesArray[$order->status] }}">
                                    {{ $statusTranslators[$order->status] }} </span>
                            </td>
                            <td>{{ date('d/m/Y', strtotime($order->created_at)) }}</td>
                            <td>{{ $order->name_user }}</td>
                            <td>
                                {{ $order->email }}
                            </td>
                            <td>
                                <a class="btn btn-primary" href="http://">Ver Detalhes</a>
                                @if ($order->status != 'cancel')
                                    <a class="btn btn-danger"
                                        href="{{ route('changeStatus', [
                                            'id' => $order->id,
                                            'status' => 'cancel',
                                        ]) }}">
                                        Cancelar
                                    </a>
                                @endif
                                @if ($order->status != 'success' && $order->status != 'cancel')
                                    <a class="btn btn-success"
                                        href="{{ route('changeStatus', [
                                            'id' => $order->id,
                                            'status' => 'success',
                                        ]) }}">
                                        Finalizar
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
