<?php

namespace App\Http\Controllers;

use App\Book as Book;
use Illuminate\Http\Request;
use App\Http\Resources\Book as BookResource;
use Illuminate\Support\Facades\Validator;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return Book::all();
        return BookResource::collection(Book::orderBy('created_at','DESC')->get())->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),  [
            'name' => 'required',
            'price' => 'required|numeric',
            'published_on' => 'required|date',
            'author_id' => 'required|exists:authors,id'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 400);
        } else {
            $book = Book::create($request->all());
            return new BookResource($book);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $validator = Validator::make($request->all(),  [
            'name' => 'required',
            'price' => 'required|numeric',
            'published_on' => 'required|date',
            'author_id' => 'required|exists:authors,id'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 400);
        } else {
            // if($book->update($request->all())){
            //     return response()->json(['Data updated successfully'],200);
            // } else {
            //     return response()->json(['Problem in updation']);
            // }

            $book = Book::updateOrCreate($request->all());
            return new BookResource($book);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        if($book->delete()){
            return response()->json(['Data deleted successfully']);
        } else {
            return response()->json(['Problem in deletion']);
        }
    }
}
