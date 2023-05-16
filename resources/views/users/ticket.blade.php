@extends('users.layout.navbar')

@section('container')
    <h1 class="mb-5 fw-bold">Your Ticket</h1>

    @foreach ($tiket as $tic)
        <form action="/detail-ticket" method="post">
            @csrf
            <input type="hidden" name="no" value="{{ $tic->no_order }}">
            <div class="card mb-5 shadow p-3 mb-5 bg-body-tertiary rounded" style="max-width: 640px;">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="{{ Storage::url('public/film/' . $tic->foto) }}" class="img-fluid rounded-start">
                    </div>
                    <div class="col-md-8">
                        @php
                            $date = date('Y-m-d');
                            
                        @endphp
                        <div class="card-body">
                            @if ($tic->jadwal_tgl < $date)
                                <button class="btn btn-outline-danger btn-sm mb-4 disabled" style="float: right;"
                                    onclick="GenerateQR()">Expired</button>
                            @else
                                <button class="btn btn-outline-success btn-sm mb-4 disabled" style="float: right;"
                                    onclick="GenerateQR()">Active</button>
                            @endif

                            <h6 class="card-title text-secondary">No Order : {{ $tic->no_order }}</h6>
                            <h1 class="card-title mt-3 text-uppercase mb-4 fw-bold">{{ $tic->film }}</h1>
                            <h6 class="text-secondary"><i class="fa-solid fa-calendar-days me-2"></i>Schedule :
                                {{ $tic->jadwal }}</h6>
                            <h6 class="text-secondary"><i class="fa-solid fa-house me-2"></i>Teater : {{ $tic->teater }}
                            </h6>
                            <h6 class="text-secondary"><i class="fa-solid fa-dollar-sign me-2"></i>Price : Rp.
                                {{ number_format($tic->total, 0, ',', '.') }}</h6>
                            <p class="card-text mt-4"><small class="text-body-secondary">Date :
                                    {{ $tic->tgl_trans }}</small></p>

                            @if ($tic->jadwal_tgl < $date)
                                <button class="btn btn-primary disabled" style="float: right;" onclick="GenerateQR()">View</button>
                            @else
                                <button class="btn btn-primary" style="float: right;" onclick="GenerateQR()">View</button>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endforeach
@endsection
