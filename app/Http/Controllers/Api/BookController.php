<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * @OA\GET(
     *      path="/books",
     *      summary="LIVROS",
     *      description="Rota para trazer e filtrar os livros",
     *      tags={"Livros"},
     *      @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Buscar por nome,descrição ou nome do autor do livro",
     *         required=false,
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request",
     *          
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */

    public function list(Request $request){
        $books=Book::query();
        
        if($request->filled('search')){
            $search=$request->input('search');
            $books->where('title','LIKE','%'.$search.'%')
                ->orWhere('description','LIKE','%'.$search.'%')
                ->orWhere('author','LIKE','%'.$search.'%');
        }

        return response()->json($books->get());
    }
}
