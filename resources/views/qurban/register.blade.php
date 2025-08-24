@extends('layouts.guest')

@section('title', 'Pendaftaran Qurban: '.$qurban->name)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Pendaftaran Qurban: {{ $qurban->name }}</h2></div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <p>Silakan isi form di bawah ini untuk mendaftar sebagai peserta qurban.</p>
                    <p>Batas waktu pendaftaran: <strong>{{ $qurban->registration_deadline }}</strong></p>

                    {!! Form::open(['route' => ['qurban.register.store', $qurban]]) !!}
                    
                    <div class="form-group">
                        {!! Form::label('qurban_offering_id', 'Pilih Hewan Kurban') !!}
                        {!! Form::select('qurban_offering_id', $qurban->offerings->pluck('name', 'id'), null, ['class' => 'form-control', 'required' => true]) !!}
                        {!! $errors->first('qurban_offering_id', '<span class="invalid-feedback" role="alert"><strong>:message</strong></span>') !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('name', 'Nama Lengkap Anda') !!}
                        {!! Form::text('name', null, ['class' => 'form-control', 'required' => true]) !!}
                        {!! $errors->first('name', '<span class="invalid-feedback" role="alert"><strong>:message</strong></span>') !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('phone_number', 'Nomor Telepon/WhatsApp') !!}
                        {!! Form::text('phone_number', null, ['class' => 'form-control', 'required' => true]) !!}
                        {!! $errors->first('phone_number', '<span class="invalid-feedback" role="alert"><strong>:message</strong></span>') !!}
                    </div>

                    {!! Form::submit('Daftar Sekarang', ['class' => 'btn btn-primary']) !!}
                    <a href="{{ url('/') }}" class="btn btn-link">Kembali ke Beranda</a>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection