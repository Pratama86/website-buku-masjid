@extends('layouts.app')

@section('title', __('library.create'))

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('library.create') }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.library.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">{{ __('book.name') }}</label>
                <input type="text" name="name" id="name" class="form-control">
            </div>
            <div class="form-group">
                <label for="description">{{ __('book.description') }}</label>
                <textarea name="description" id="description" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="cover">{{ __('book.cover') }}</label>
                <input type="file" name="cover" id="cover" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">{{ __('app.create') }}</button>
            <a href="{{ route('admin.library.index') }}" class="btn btn-link">{{ __('app.cancel') }}</a>
        </form>
    </div>
</div>
@endsection
