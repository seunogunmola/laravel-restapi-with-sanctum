<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Traits\HasApiResponse;

class BookController extends Controller
{
    use HasApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::latest()->get();
        if ($books) {
            $data = BookResource::collection($books);
            return $this->success(
                'Books retrieved successfully',
                $data
            );
        } else {
            return $this->error(
                'No books found',
                404
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $data = $request->validated();

        if ($book = Book::create($data)) {
            $message = "Book Created Successfully";
            return $this->success($message, $book, 201);
        } else {
            $message = "An Error Occured";
            return $this->error($message, 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $book = Book::find($id);
        if ($book) {
            return $this->success(
                'Book retrieved successfully',
                BookResource::make($book)
            );
        } else {
            return $this->error(
                'Book not found',
                404
            );
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        $validatedData = $request->validated();
        if ($book->update($validatedData)) {
            $message = "Book Updated Successfully";
            return $this->success(
                $message,
                BookResource::make($book)
            );
        } else {
            return $this->error('An Error Occured', 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if ($book = Book::find($id)) {
            $book->delete();
            return $this->success(
                "Book Deleted Successfully",
                [],
                200
            );
        } else {
            return $this->error(
                "Book Not Found",
                404
            );
        }
    }
}
