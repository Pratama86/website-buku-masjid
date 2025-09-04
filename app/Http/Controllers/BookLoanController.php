<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookLoan;
use Illuminate\Http\Request;

class BookLoanController extends Controller
{
    public function store(Request $request, Book $book)
    {
        $loan = new BookLoan;
        $loan->book_id = $book->id;
        $loan->user_id = auth()->id();
        $loan->loan_date = now();
        $loan->save();

        return redirect()->route('library.index')->with('success', __('book.loaned'));
    }
}
