<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

use App\Models\Book;
use App\Http\Resources\BookResource;
use App\Http\Resources\BookCollection;
use App\Http\Requests\BookRequest;
use App\Http\Requests\BookUpdateRequest;

class BookController extends Controller
{
    public function get($id)
    {
        $book = Book::where('id', $id)->first();
        if(!$book){
            return response()->json([
                'errors' => [
                    'message' => [
                        'Not Found'
                    ]
                ]
            ], 400);
        }
        return new BookResource($book);
    }

    public function store(BookRequest $request)
    {
        $data = $request->validated();
    
        if(Book::where('title', $data['title'])->first()){
            return response()->json([
                'errors' => [
                    'message' => [
                        'Title Already Exist',
                    ]
                ]
            ], 400);
        }
        $title = new Book($data);
        $title->save();

        return response()->json([
            'message' => 'Book Created Successfully',
            'data' => new BookResource($title)
        ]); 
    }

    public function update(BookUpdateRequest $request, $id)
    {
        $book = Book::where('id', $id)->first();
        if(!$book){
            return response()->json([
                'errors' => [
                    'message' => [
                        'Not Found'
                    ]
                ]
            ], 400);
        }

        $data = $request->validated();
        // dd($data);
        $book->fill($data);
        $book->save();
        
        return response()->json([
            'message' => 'Book Updated Succesfully',
            'data' => new BookResource($book)
        ]);
    }

    public function delete($id)
    {
        $book = Book::where('id', $id)->first();
        if(!$book){
            return response()->json([
                'Errors' => [
                    'message' => [
                        'Not Found'
                    ]
                ]
            ], 400);
        }

        $book->delete();
        return response()->json([
            'message' => 'Book Deleted Succesfully',
            'data' => true
        ]);
    }

    public function search(Request $request)
    {
        $books = Book::query();

        $books = $books->where(function (Builder $builder) use ($request){
            $title = $request->input('title');
            if ($title) {
                $builder->where('title', 'like', '%'. $title . '%');
            }
    
            $publisher = $request->input('publisher');
            if ($publisher) {
                $builder->orWhere('publisher', 'like', '%'. $publisher . '%');
            }
    
            $publishYear = $request->input('publish_year');
            if ($publishYear) {
                $builder->orWhere('publish_year', 'like', '%'. $publishYear . '%');
            }
        });
    
        return new BookCollection($books->get());
        
    }
}
