@php use Illuminate\Support\Str; @endphp
@extends('layouts.guest')

@push('styles')
<style>
    .news-header {
        background-color: #f8f9fa;
        padding: 2rem;
        border-radius: 0.5rem;
        margin-bottom: 2rem;
    }
    .news-card {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        border: none;
    }
    .news-card:hover {
        transform: scale(1.03);
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }
    .news-card-img {
        height: 200px;
        object-fit: cover;
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <div class="news-header text-center">
        <h1 class="mb-3">Berita Terkini</h1>
        <p class="lead">Berikut adalah rangkuman berita teratas dari berbagai sumber. Daftar ini diperbarui secara otomatis setiap hari.</p>
    </div>

    @if(!empty($articles))
        <div class="row">
            @foreach($articles as $article)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 news-card">
                        @if($article['urlToImage'])
                            <img src="{{ $article['urlToImage'] }}" class="card-img-top news-card-img" alt="{{ $article['title'] }}">
                        @else
                            <div class="card-img-top news-card-img d-flex align-items-center justify-content-center bg-light">
                                <small class="text-muted">Gambar tidak tersedia</small>
                            </div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $article['title'] }}</h5>
                            <p class="card-text text-muted flex-grow-1">{{ Str::limit($article['description'], 100) }}</p>
                            <a href="{{ $article['url'] }}" class="btn btn-primary mt-auto" target="_blank">Baca Selengkapnya</a>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Sumber: {{ $article['source']['name'] }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <p class="lead">Tidak ada berita untuk ditampilkan saat ini.</p>
        </div>
    @endif
</div>
@endsection