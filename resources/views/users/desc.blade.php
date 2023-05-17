@extends('users.layout.navbar')

@section('style')
    <link rel="stylesheet" href="/assets/css/desc.css">

    <style>
        .col-10 h1 {
            font-weight: 700;
            text-transform: uppercase;
        }

        .col-10 h2 {
            font-size: 18px;
            font-weight: 600;
            color: #6e6e6e;
        }

        .desc > h1{
            text-transform: uppercase;
        }

        .desc > p {
            font-family: 'Comfortaa', cursive;
        }
    </style>
@endsection

@section('container')
    <div class="main">
        <div class="main-desc">
            <img src="{{ Storage::url('public/film/' . $film->foto) }}">
            <div class="desc">
                <h1>{{ $film->nama }}</h1>
                <h2>Genre : {{ $film->genre }}</h2>
                <h2>Duration : {{ $film->durasi }}</h2>
                <p>{{ $film->deskripsi }}</p>

                <form action="/book" method="post">
                    @csrf
                    <input type="hidden" name="film" value="{{ $film->id }}">

                    <div class="pnl">
                        <h1>Teater : </h1>
                        <div class="row">
                            @foreach ($teater as $t)
                                <label class="radio">
                                    <input type="radio" value="{{ $t->id }}" name="teater" required>
                                    <h1><i class="fa-solid fa-film me-2"></i>{{ $t->nama }}</h1>
                                    <p><i class="fa-solid fa-dollar-sign me-2"></i>Rp.
                                        {{ number_format($t->harga, 0, ',', '.') }}</p>
                                    <span></span>
                                </label>
                            @endforeach
                        </div>
                        @php
                            $today = date('Y-m-d');
                        @endphp
                        <h6 class="ms-4 mt-4 fw-bold">Select Date : </h6>
                        <input type="date" class="form-control w-50 ms-3 mb-2" name="tanggal" min="{{ $today }}">
                        <button class="btn btn-warning mt-4 ms-3 mb-3" type="submit">Book</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
