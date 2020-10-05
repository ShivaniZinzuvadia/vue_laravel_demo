<?php

namespace App\Http\Controllers;

use App\Author as Author;
use Illuminate\Http\Request;
use App\Http\Resources\Author as AuthorResource;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AuthorResource::collection(Author::orderby('created_at', 'DESC')->get())->all();
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
            'email' => 'required|email|unique:authors,email',
            'mobile' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 400);
        } else {
            $author = Author::create($request->all());
            return new AuthorResource($author);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Author $author)
    {
        $validator = Validator::make($request->all(),  [
            'name' => 'required',
            'email' => 'required|email|unique:authors,email,'.$author->id,
            'mobile' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 400);
        } else {
            // if($author->update($request->all())){
            //     return response()->json(['Data updated successfully'],200);
            // } else {
            //     return response()->json(['Problem in updation']);
            // }
            $author = Author::updateOrCreate($request->all());
            return new AuthorResource($author);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        if($author->delete()){
            return response()->json(['Data deleted successfully']);
        } else {
            return response()->json(['Problem in deletion']);
        }
    }
}
