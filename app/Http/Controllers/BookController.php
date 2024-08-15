<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    use ApiResponseTrait;


    public function index(){

        $books = Book::orderBy('created_at','Desc')->get();
        return $this->apiResponse($books, 'ok', 200);
    }


    public function book_details($id)
    {
      $book = Book::where('id', $id)->first();

      if($book){
        return $this->apiResponse($book, 'This details of the book', 201);
      }
      else{
        return $this->apiResponse(null, 'This book is not found', 404);
      }
    }


    public function store(Request $request)
    {
        try{
            $validator = Validator([
                'title' => 'required|max:255',
                'author' => 'required',
                'publication_year' => 'required|number|min:4|max:4',
                'ISBN' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->apiResponse(null, $validator->errors(), 400);
            }

            $book = new Book(); 
            $book->title = $request->title;
            $book->author = $request->author;
            $book->publication_year = $request->publication_year;
            $book->ISBN = $request->ISBN;
            $book->save();

            if($book){
                return $this->apiResponse($book, 'The book save', 201);
            }
            return $this->apiResponse(null, 'This book not save', 400);

        }
        catch(\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function update(Request $request, $id)
    {
        try{
            $validator = Validator([
                'title' => 'required|max:255',
                'author' => 'required',
                'publication_year' => 'required|number|min:4|max:4',
                'ISBN' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->apiResponse(null, $validator->errors(), 400);
            }

            $book = Book::find($id); 
            if(!$book){
                return $this->apiResponse(null, 'This book not found', 404);
            }

            $book->title = $request->title;
            $book->author = $request->author;
            $book->publication_year = $request->publication_year;
            $book->ISBN = $request->ISBN;
            $book->update();

            if($book){
                return $this->apiResponse($book, 'The book update', 201);
            }
        }
        catch(\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function destroy($id){

        $book = Book::find($id); 
        if(!$book){
            return $this->apiResponse(null, 'This book not found', 404);
        }

        $book->delete($id);
        if($book){
            return $this->apiResponse(null, 'This book deleted', 200);
        }
    }

}
