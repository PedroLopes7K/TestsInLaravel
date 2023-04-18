<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Book $book)
    {
        return response()->json($book->all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $book = Book::create($request->all());

       return response()->json($book, 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return response()->json($book);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       $book = Book::find($id);

       $book->update($request->all());

       return response()->json($book, 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
