<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Author;
use App\Http\Resources\AuthorResource;
use App\Http\Requests\AuthorRequest;
use App\Http\Requests\AuthorUpdateRequest;

class AuthorController extends Controller
{
    public function get()
    {
        $data = Author::all();

        return response()->json([
            'message' => 'succes',
            'data' => $data
        ],200);
        // return new AuthorResource($dataAuthor);
       
    }

    public function store(AuthorRequest $request)
    {
        $data = $request->validated();

        if(Author::where('name', $data['name'])->first()){
            return response()->json([
                'errors' => [
                    'message' => [
                        'Author Already Exist',
                    ]
                ]
            ], 400);
        }
        $author = new Author($data);
        $author->save();

        return response()->json([
            'message' => 'Author Created Successfully',
            'data' => new AuthorResource($author)
        ]);
    }

    public function update(AuthorUpdateRequest $request, $id)
    {
        $author = Author::where('id', $id)->first();
        if(!$author){
            return response()->json([
                'errors' => [
                    'message' => [
                        'Not Found',
                    ]
                ]
            ], 400);
        }

        $data = $request->validated();
        $author->fill($data);
        $author->save();

        return response()->json([
            'message' => 'Author Updated Successfully',
            'data' => new AuthorResource($author)
        ]);
    }

    public function delete($id)
    {
        $author = Author::where('id', $id)->first();
        if(!$author){
            return response()->json([
                'errors' => [
                    'message' => [
                        'Not Found',
                    ]
                ]
            ], 400);
        }

        $author->delete();
        return response()->json([
            'message' => 'Author Deleted Successfully',
            'data' => true
        ]);
    }
}
