@extends('adminlte::page')

@section('content')
    <div class="content-header">
        <div class="card">
            <div class="card-header" style="text-align: center;">
                <h3>Adicionar Livro</h3>
            </div>
            <div class="card-body d-flex justify-content-center">
                <form class="card w-50 p-2" enctype="multipart/form-data"  method="post">
                    @csrf   
                    <input type="file" name="image" class="d-none" id="bookFile">
                    <label for="bookFile" class="d-flex justify-content-center">
                        <div class="bookImage">
                            <img src="{{asset('/images/book.png')}}" width="100%" alt="bookImage">
                        </div>
                    </label>
                    
                    <div class="form-group">
                        <input 
                            class="form-control" 
                            type="text" 
                            placeholder="Digite o titulo do livro" 
                            name="title"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <input 
                            class="form-control" 
                            type="number" 
                            placeholder="Digite o preço do livro" 
                            name="price"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <input 
                            class="form-control" 
                            placeholder="Digite o autor do livro" 
                            name="author"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <textarea 
                            class="form-control" 
                            name="description" 
                            placeholder="Digite a descrição do livro"
                            cols="30" 
                            rows="5"
                            required
                        >
                            
                        </textarea>
                    </div>
                
                    <div class="form-group d-flex justify-content-center w-100">
                        <input class="btn btn-info w-100" type="submit" value="Salvar">
                    </div>
            </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('js/script.js')}}"></script>
@endsection