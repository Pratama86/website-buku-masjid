@extends('layouts.app')

@section('title', __('library.library'))

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('library.library') }}</h3>
        <div class="card-options">
            <a href="{{ route('admin.library.create') }}" class="btn btn-success btn-sm">{{ __('library.create') }}</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-sm table-hover">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>{{ __('book.name') }}</th>
                    <th>{{ __('book.description') }}</th>
                    <th>{{ __('app.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $key => $book)
                    <tr>
                        <td class="text-center">{{ $key + 1 }}</td>
                        <td>{{ $book->name }}</td>
                        <td>{{ $book->description }}</td>
                        <td>
                            <a href="{{ route('admin.library.edit', $book) }}" class="btn btn-warning btn-sm">{{ __('app.edit') }}</a>
                            <form action="{{ route('admin.library.destroy', $book) }}" method="POST" onsubmit="return confirm('{{ __('book.delete_confirm') }}')" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">{{ __('app.delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
