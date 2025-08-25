<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Book;
use App\Models\QurbanEvent;

class PublicBookController extends Controller
{
    public function index()
    {
        $bankAccounts = BankAccount::where('is_active', BankAccount::STATUS_ACTIVE)->get();
        $publicBooks = Book::where('report_visibility_code', Book::REPORT_VISIBILITY_PUBLIC)
            ->where('report_periode_code', Book::REPORT_PERIODE_ALL_TIME)
            ->get();
        $activeQurbanEvents = QurbanEvent::where('registration_deadline', '>=', today())
            ->with('offerings.participants')->latest()->get();

        return view('guest.books.index', compact('bankAccounts', 'publicBooks', 'activeQurbanEvents'));
    }

    public function show(Book $book)
    {
        return view('guest.books.show', compact('book'));
    }
}
