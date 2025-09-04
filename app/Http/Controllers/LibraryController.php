<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LibraryController extends Controller
{
    public function index()
    {
        $books = Book::all();

        return view('library.index', compact('books'));
    }

    public function adminIndex()
    {
        $books = Book::all();

        return view('library.admin.index', compact('books'));
    }

    public function create()
    {
        return view('library.admin.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'cover' => 'required|image|max:2048',
        ]);

        $book = new Book;
        $book->name = $request->name;
        $book->description = $request->description;
        $book->cover_path = $request->file('cover')->store('library', 'public');
        $book->save();

        return redirect()->route('admin.library.index')->with('success', __('book.created'));
    }

    public function edit(Book $book)
    {
        return view('library.admin.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'cover' => 'nullable|image|max:2048',
        ]);

        $book->name = $request->name;
        $book->description = $request->description;

        if ($request->hasFile('cover')) {
            if ($book->cover_path) {
                Storage::disk('public')->delete($book->cover_path);
            }
            $book->cover_path = $request->file('cover')->store('library', 'public');
        }

        $book->save();

        return redirect()->route('admin.library.index')->with('success', __('book.updated'));
    }

    public function destroy(Book $book)
    {
        if ($book->cover_path) {
            Storage::disk('public')->delete($book->cover_path);
        }

        $book->delete();

        return redirect()->route('admin.library.index')->with('success', __('book.deleted'));
    }
}
