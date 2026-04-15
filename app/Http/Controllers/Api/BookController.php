<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\IndexBookRequest;
use App\Http\Requests\Api\StoreBookRequest;
use App\Http\Requests\Api\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Dedoc\Scramble\Attributes\QueryParameter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class BookController extends Controller
{
    /**
     * Display a listing of books.
     */
    #[QueryParameter('perPage', description: 'The number of books to return per page', default: 15)]
    public function index(Request $request): AnonymousResourceCollection
    {
        $books = Book::query()
            ->orderBy('title')
            ->paginate((int) $request->query('perPage', 15));

        return BookResource::collection($books);
    }

    /**
     * Store a newly created book in storage.
     */
    public function store(StoreBookRequest $request): JsonResponse
    {
        $book = Book::query()->create($request->validated());

        return BookResource::make($book)
            ->response($request)
            ->setStatusCode(201);
    }

    /**
     * Display the specified book.
     */
    public function show(Book $book): BookResource
    {
        return new BookResource($book);
    }

    /**
     * Update the specified book (PUT: full replacement, PATCH: partial).
     */
    public function update(UpdateBookRequest $request, Book $book): BookResource
    {
        $book->update($request->validated());

        return new BookResource($book->fresh());
    }

    /**
     * Remove the specified book from storage.
     */
    public function destroy(Book $book): Response
    {
        $book->delete();

        return response()->noContent();
    }
}
