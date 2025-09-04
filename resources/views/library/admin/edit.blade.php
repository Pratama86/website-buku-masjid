@extends('layouts.app')

@section('title', __('library.edit'))

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('library.edit') }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.library.update', $book) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">{{ __('book.name') }}</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $book->name }}">
            </div>
            <div class="form-group">
                <label for="description">{{ __('book.description') }}</label>
                <textarea name="description" id="description" class="form-control">{{ $book->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="cover">{{ __('book.cover') }}</label>
                <input type="file" name="cover" id="cover" class="form-control">
                @if ($book->cover_path)
                    <img src="{{ asset('storage/' . $book->cover_path) }}" alt="{{ $book->name }}" class="img-thumbnail mt-2" width="150">
                @endif
            </div>
            <button type="submit" class="btn btn-success">{{ __('app.update') }}</button>
            <a href="{{ route('admin.library.index') }}" class="btn btn-link">{{ __('app.cancel') }}</a>
        </form>
    </div>
</div>
@endsection
