@extends('users.layout.navbar')

@section('style')
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


        /* radio */

        .radio {
            font-size: 20px;
            font-weight: 600;
            text-transform: capitalize;
            display: inline-block;
            vertical-align: middle;
            margin: 30px 15px;
            position: relative;
            padding-left: 35px;
            padding-top: 5px;
            padding-bottom: 5px;
            padding-right: 5px;
            cursor: pointer;
            color: #fff;
            transition: 0.5s;
            border: 2px solid #414141;
            border-radius: 10px;
            background-color: #414141;
            box-shadow: 2px 2px 2px #000;
        }

        .radio:hover {
            color: #7a7a7a;
        }

        .radio input[type="radio"] {
            display: none;
        }

        .radio span {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 3px solid #fff;
            display: block;
            position: absolute;
            left: 5px;
            top: 11px;

        }

        .radio span:after {
            content: "";
            height: 8px;
            width: 8px;
            background-color: #fff;
            display: block;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%) scale(0);
            border-radius: 50%;
            transition: 0.2s ease-in-out 0s;

        }

        .radio input[type="radio"]:checked~span:after {
            transform: translate(-50%, -50%) scale(1.5);
        }

        .pnl {
            background-color: #dddddd;
            width: 650px;
            border-radius: 20px;
            border: 2px outset #414141;
            box-shadow: 2px 2px 3px #000;
            flex-wrap: wrap;
            margin-top: 40px;

        }

        .pnl>h1 {
            margin-left: 20px;
            font-size: 30px;
            margin-bottom: 10px;
            font-weight: 700;
            margin-top: 20px;
        }
    </style>
@endsection

@section('container')
    <div class="row">
        <div class="col-2">
            <img src="{{ Storage::url('public/film/' . $film->foto) }}" style="width: 200px; border-radius: 20px;">
        </div>
        <div class="col-10">
            <h1 class="mb-3">{{ $film->nama }}</h1>
            <h2><i class="fa-solid fa-list me-2"></i>Genre : {{ $film->genre }}</h2>
            <h2><i class="fa-solid fa-clock me-2"></i>Duration : {{ $film->durasi }}</h2>
            <h2><i class="fa-solid fa-house me-2"></i>Teater : {{ $teater->nama }}</h2>
            <h2><i class="fa-solid fa-calendar-days me-2"></i>Broadcast date : {{ $tanggal }}</h2>
            <h2 class="mb-5 fw-bold"><i class="fa-solid fa-dollar-sign me-2"></i>Price : Rp.
                {{ number_format($teater->harga, 0, ',', '.') }}</h2>

            <div class="pnl">
                <h1>Schedule : </h1>
                <form action="/seat" method="post">
                    @csrf
                    <input type="hidden" name="film" value="{{ $film->id }}">
                    <input type="hidden" name="teater" value="{{ $teater->id }}">
                    <input type="hidden" name="tanggal" value="{{ $tanggal }}">
                    <div>
                        @foreach ($jadwal as $j)
                            @if ($tanggal == date('Y-m-d'))
                                @if ($j->start > $today)
                                    <label class="radio">
                                        <input type="radio" value="{{ $j->id }}" name="jadwal" required>
                                        {{ $j->start }} - {{ $j->end }}
                                        <span></span>
                                    </label>
                                @endif
                            @else
                                <label class="radio">
                                    <input type="radio" value="{{ $j->id }}" name="jadwal" required>
                                    {{ $j->start }} - {{ $j->end }}
                                    <span></span>
                                </label>
                            @endif
                        @endforeach
                    </div>
                    <div>
                        <button type="submit" class="btn btn-warning m-3">Book</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
