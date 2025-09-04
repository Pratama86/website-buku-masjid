@extends('layouts.app')

@section('title', __('library.library'))

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('library.library') }}</h3>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach ($books as $book)
                <div class="col-md-4">
                    <div class="card">
                        <img class="card-img-top" src="{{ asset('storage/' . $book->cover_path) }}" alt="{{ $book->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $book->name }}</h5>
                            <p class="card-text">{{ $book->description }}</p>
                            <form action="{{ route('library.loan', $book) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">{{ __('library.borrow') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
