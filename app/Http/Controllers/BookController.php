<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function add(Request $request)
    {
        if($request->filled(['title','description','price'])){
            $filePath = "";
            if($request->has('image')){
                $filePath = $this->uploadFile($request);
            }

            $book=new Book();
            $book->title=$request->input('title');
            $book->description=$request->input('description');
            $book->price="R$ ".str_replace('.',',',number_format($request->input('price'),2));
            $book->author=$request->input('author');
            $book->img=$filePath;
            $book->save();
            return redirect()->route('home');
        }
        
        return view('addBook');
    }

    public function edit(Request $request,$id)
    {
        $book=Book::where('id',$id)->first();
        
        if($request->filled(['title','description','price','author'])){
            $book=Book::where('id',$request->input('id'))->first();
            $filePath = $book->img;
            if($request->has('image')){
                $filePath = $this->uploadFile($request);
            }
            
            $book->title=$request->input('title');
            $book->description=$request->input('description');
            $book->price="R$ ".str_replace('.',',',number_format($request->input('price'),2));
            $book->author=$request->input('author');
            $book->img=$filePath;
            $book->save();
            return redirect()->route('home');
        }
        
        return view('editBook',['book'=>$book]);
    }

    private function uploadFile($request)
    {
        $file = md5(rand(0, 99999) . rand(0, 99999)) . '.' . $request->file('image')->getClientOriginalExtension();
        $path = "public/images/";
        $request->file('image')->storeAs($path, $file);
        $pathFile = url('/') . "/storage/images/" . $file;

        return $pathFile;
    }

    public function delete($id)
    {
        $book=Book::where('id',$id)->first();
        $book->delete();

        return redirect()->route('home');
    }
}
