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

                    {!! Form::open(['route' => ['qurban.register.store', $qurban], 'files' => true]) !!}
                    
                    <div class="form-group">
                        {!! Form::label('qurban_offering_id', 'Pilih Hewan Kurban') !!}
                        {!! Form::select('qurban_offering_id', $qurban->offerings->pluck('name', 'id'), null, ['class' => 'form-control', 'required' => true]) !!}
                        {!! $errors->first('qurban_offering_id', '<span class="invalid-feedback" role="alert"><strong>:message</strong></span>') !!}
                    </div>

                    @php
                        $totalParticipants = $qurban->offerings->sum(function ($offering) {
                            return $offering->participants->count();
                        });
                        $totalLimit = $qurban->offerings->sum('participant_limit');
                        $isFull = $totalLimit > 0 && $totalParticipants >= $totalLimit;
                    @endphp

                    <div class="alert alert-info">
                        Jumlah Pendaftar Saat Ini: <strong>{{ $totalParticipants }}</strong>
                        @if ($totalLimit)
                            / <strong>{{ $totalLimit }}</strong> orang
                        @endif
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

                    <div class="form-group">
                        {!! Form::label('photo', 'Foto Anda') !!}
                        <div>
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#cameraModal">
                                Ambil Foto
                            </button>
                        </div>
                        <input type="hidden" name="photo" id="photo_base64">
                        <img id="photo_preview" src="" style="max-width: 200px; margin-top: 10px;"/>
                        {!! $errors->first('photo', '<span class="invalid-feedback" role="alert"><strong>:message</strong></span>') !!}
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="cameraModal" tabindex="-1" aria-labelledby="cameraModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="cameraModalLabel">Ambil Foto</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <video id="camera_stream" width="100%" autoplay></video>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="capture_button">Ambil Gambar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <canvas id="canvas" style="display:none;"></canvas>

                    @push('scripts')
                    <script>
                        const cameraStream = document.getElementById('camera_stream');
                        const captureButton = document.getElementById('capture_button');
                        const canvas = document.getElementById('canvas');
                        const photoBase64 = document.getElementById('photo_base64');
                        const photoPreview = document.getElementById('photo_preview');
                        const cameraModal = new bootstrap.Modal(document.getElementById('cameraModal'));

                        document.getElementById('cameraModal').addEventListener('shown.bs.modal', function () {
                            navigator.mediaDevices.getUserMedia({ video: true })
                                .then(function (stream) {
                                    cameraStream.srcObject = stream;
                                })
                                .catch(function (err) {
                                    console.log("An error occurred: " + err);
                                });
                        });

                        captureButton.addEventListener('click', function () {
                            const context = canvas.getContext('2d');
                            canvas.width = cameraStream.videoWidth;
                            canvas.height = cameraStream.videoHeight;
                            context.drawImage(cameraStream, 0, 0, canvas.width, canvas.height);
                            const dataURL = canvas.toDataURL('image/jpeg');
                            photoBase64.value = dataURL;
                            photoPreview.src = dataURL;
                            cameraModal.hide();
                            const stream = cameraStream.srcObject;
                            const tracks = stream.getTracks();
                            tracks.forEach(track => track.stop());
                            cameraStream.srcObject = null;
                        });
                    </script>
                    @endpush

                    {!! Form::submit('Daftar Sekarang', ['class' => 'btn ' . ($isFull ? 'btn-danger' : 'btn-primary'), 'disabled' => $isFull]) !!}
                    <a href="{{ url('/') }}" class="btn btn-link">Kembali ke Beranda</a>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection