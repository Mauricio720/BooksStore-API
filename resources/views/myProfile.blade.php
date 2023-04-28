@extends('adminlte::page')

@section('content')
    <div class="content-header">
        <div class="card">
            <div class="card-header" style="text-align: center;">
                <h3>Edite seu perfil</h3>
            </div>
            <div class="card-body d-flex justify-content-center">
                <form class="card w-50 p-2" action="{{route('updateUser')}}" method="post">
                    @csrf   
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="Digite seu nome"
                            name="name"value="{{Auth::user()->name}}">
                    </div>

                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="Digite seu email"
                            name="email"value="{{Auth::user()->email}}">
                    </div>

                    <div class="form-group">
                        <input class="form-control" type="password" placeholder="Digite sua senha"
                            name="password"value="{{Auth::user()->email}}">
                    </div>
                    <div class="form-group d-flex justify-content-center">
                        <input class="btn btn-info" type="submit" value="Salvar">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
