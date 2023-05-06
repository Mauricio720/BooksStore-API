@extends('adminlte::page')

@section('content')
    <div class="container">
        <div class="card-header w-100">
            <h4>Usuários</h4>
        </div>
        <div class="card-header w-100">
            <form class="d-flex" action="" method="get">
                <div class="form-group w-75">
                    <input class="form-control" name="search" value="{{ $search }}" placeholder="Digite o nome ou email"
                        type="text">
                </div>
                <div class="form-group ml-2">
                    <input class="btn btn-success" type="submit" value="Pesquisar">
                </div>
            </form>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>

                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <a class="btn {{ $user->block === 0 ? 'btn-danger' : 'btn-success' }}"
                                    href="{{ route('blockUnlock', ['id' => $user->id]) }}">{{ $user->block === 0 ? 'Bloquear' : 'Desbloquear' }}</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
