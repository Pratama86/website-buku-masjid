@extends('layouts.guest')

@section('title', __('book.program'))

@section('content')
<section class="bg-white">
    <div class="container-md">
        <div class="section-hero row">
            <div class="col">
                @include('layouts.public._masjid_info')
            </div>
            <div class="d-none d-lg-flex align-items-center col-7 position-relative">
                <img src="{{ asset('images/donate_infaq.png') }}" style="width: 80%">
                <img src="{{ asset('images/donate_pattern.svg') }}" class="position-absolute" style="z-index: 0">
            </div>
        </div>
    </div>
</section>
<div class="section-bottom">
    <div class="container-md p-3 home-bottom">
        <h2 class="fw-bolder mb-3">infak</h2>
        <div class="row row-cols-lg-2 row-cols-xl-3">
            @forelse ($bankAccounts as $bankAccount)
                <div class="col-lg ps-sm-0">
                    <div class="card fw-bold p-3 mb-2 shadow-lg">
                        <!-- QRIS -->
                        @if (Setting::for($bankAccount)->get('qris_image_path'))
                            <div class="modal fade" id="qris-{{ $bankAccount->number }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">QRIS BSI</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <img src="{{ Storage::url(Setting::for($bankAccount)->get('qris_image_path'))}}" alt="QRIS">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="fs-6 btn btn-sm bm-btn btn-outline-cyan position-absolute end-0 bottom-0 me-3 px-2 py-1 mb-3" data-bs-toggle="modal" data-bs-target="#qris-{{ $bankAccount->number }}">
                                Lihat QRIS
                            </button>
                        @endif
                        <div class="mb-3 py-2 px-3 fs-3" style="border-radius: 10px; border: 1px solid #cfeeeb; background-color: #F4FFFF">
                            {{ $bankAccount->description }}
                        </div>
                        <div class="row">
                            <div class="col-auto lh-1">
                                <span class="date">Nama Bank</span><br>
                                <h3>{{ $bankAccount->name }}</h3>
                            </div>
                            <div class="col-lg lh-1 pt-3 pt-lg-0">
                                <span class="date">Atas Nama</span><br>
                                <h3>{{ $bankAccount->account_name }}</h3>
                            </div>
                        </div>

                        <div class="pt-3 pt-lg-4">
                            <span class="date">No Rek</span><br>
                            <h1 class=" bm-txt-primary fw-bolder">{{ $bankAccount->number }}</h1>
                        </div>
                    </div>
                </div>
            @empty
                {{ __('bank_account.empty') }}
            @endforelse
        </div>
        <div class="pt-3 mt-4 border-top">
            <h2 class="fw-bolder">Program Spesial</h2>
        </div>
        @if ($activeQurbanEvents->isNotEmpty())
            <div class="row row-cols-lg-3">
                @foreach ($activeQurbanEvents as $qurbanEvent)
                <div class="col-md-6 mt-3">
                    <div class="card">
                        <div>
                            @if ($qurbanEvent->image_path)
                                <img src="{{ asset('uploads/' . $qurbanEvent->image_path) }}" class="w-100 h-100 object-cover" alt="{{ $qurbanEvent->name }}" style="border-radius: 15px 15px 0px 0px;">
                            @else
                                <div class="p-3 fs-1 d-flex align-items-center justify-content-center bg-success-lt" style="min-height: 207px;border-radius: 15px 15px 0px 0px;">{{ $qurbanEvent->name }}</div>
                            @endif
                        </div>
                        <div>
                            <div class="p-4">
                                <h3 class="fs-1">{{ $qurbanEvent->name }}</h3>
                                <div class="text-secondary py-3 mt-3">Batas pendaftaran: {{ $qurbanEvent->registration_deadline }}</div>
                                @php
                                    $totalParticipants = $qurbanEvent->offerings->sum(function ($offering) {
                                        return $offering->participants->count();
                                    });
                                    $totalLimit = $qurbanEvent->offerings->sum('participant_limit');
                                    $isFull = $totalLimit > 0 && $totalParticipants >= $totalLimit;
                                @endphp
                                <div class="alert alert-info">
                                    Jumlah Pendaftar Saat Ini: <strong>{{ $totalParticipants }}</strong>
                                    @if ($totalLimit)
                                        / <strong>{{ $totalLimit }}</strong> orang
                                    @endif
                                </div>
                                <a href="{{ route('qurban.register', $qurbanEvent) }}" class="btn {{ $isFull ? 'btn-danger' : 'btn-success' }} mt-3" role="button" style="border-radius: 9px !important;" {{ $isFull ? 'disabled' : '' }}>
                                    {{ $isFull ? 'Kuota Penuh' : 'Daftar Qurban Sekarang' }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
        <div class="pt-3 mt-4 border-top">
            <h2 class="fw-bolder">{{ __('book.program') }}</h2>
        </div>
        @if ($publicBooks->isEmpty() == false)
            <div class="row row-cols-lg-3">
                @foreach ($publicBooks as $publicBook)
                <div class="col-md-6 mt-3">
                    <div class="card">
                        <div>
                            @if (Setting::for($publicBook)->get('poster_image_path'))
                                <img src="{{ asset('uploads/'.Setting::for($publicBook)->get('poster_image_path')) }}" class="w-100 h-100 object-cover" alt="{{ $publicBook->name }}" style="border-radius: 15px 15px 0px 0px;">
                            @else
                                <div class="p-3 fs-1 d-flex align-items-center justify-content-center bg-info-lt" style="min-height: 207px;border-radius: 15px 15px 0px 0px;">{{ $publicBook->name }}</div>
                            @endif
                        </div>
                        <div>
                            <div class="p-4">
                                <h3 class="fs-1">{{ $publicBook->name }}</h3>
                                @if ($publicBook->budget)
                                    
                                    <div class="progress progress-bar-striped rounded-pill mt-4" style="height: 10px;">
                                        <div class="progress-bar progress-bar-striped rounded-pill bg-{{ $publicBook->progress_percent_color }}" style="width: {{ $publicBook->progress_percent }}%"></div>
                                    </div>
                                    <div class="d-flex grid-cols-2 mt-3 ">
                                        <div class="col-6 text-srart">
                                            <span>Terkumpul</span><br>
                                            <strong class="bm-txt-primary fw-bolder">{{ config('money.currency_code') }} {{ format_number($publicBook->income_total) }}</strong>
                                        </div>
                                        <div class="col-6 text-end">
                                            <span>Target</span><br>
                                            <strong class="bm-txt-primary fw-bolder">{{ config('money.currency_code') }} {{ format_number($publicBook->budget) }}</strong>
                                        </div>
                                    </div>
                                @endif
                                <div class="text-secondary py-3 mt-3">{{ $publicBook->description }}</div>
                                <a href="{{ route('public.books.show', $publicBook) }}" class="btn btn-primary mt-3" role="button" style="background-color: #2d6974 !important; border-radius: 9px !important;">{{ __('app.show') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="container-xl my-auto card bg-light">
                <div class="empty">
                    <p class="empty-subtitle text-secondary">{{ __('book.no_book') }}</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
