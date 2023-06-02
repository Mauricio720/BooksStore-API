<?php

use App\Models\Book;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeColumnPriceBook extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $books=Book::all();
        foreach ($books as  $book) {
            $price=$book->price;
            $price = preg_replace("/[^0-9,]/", "", $price);
            $price = str_replace(",", ".", $price);
            $price = (float) $price;
            
            $book->price=$price;
            $book->save();
        }

        DB::statement('ALTER TABLE `books` MODIFY price float');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE `books` MODIFY price varchar(255)');
    }
}
