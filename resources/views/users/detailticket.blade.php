@extends('users.layout.navbar')

@section('style')
    <style>
        .h1 {
            font-weight: 700;
            text-transform: uppercase;
        }

        .h2 {
            font-size: 18px;
            font-weight: 600;
            color: #6e6e6e;
        }

        /* detail transaksi */

        .detail-transaksi {
            width: 90%;
            height: 450px;
            background-color: #414141;
            margin: 20px 0;
            border-radius: 20px;
            box-shadow: 4px 4px 8px #ff842b;
        }

        .detail-transaksi h1 {
            color: #fff;
            font-size: 34px;
            padding: 25px;
            font-weight: 700;
        }

        .detail-transaksi h2{
            color: #c4c4c4;
            padding: 0 40px;
            font-size: 24px;
        }

        .desc {
            margin: 20px 40px;
        }

        .desc p {
            color: #eaddcd;
            font-size: 18px;
            font-weight: 500;
        }

        .detail-transaksi h3{
            font-size: 30px;
            margin: 20px 40px;
            color: #ff842b;
        }

        /* pembayaran */

        .pembayaran {
            width: 90%;
            height: 300px;
            background-color: #414141;
            margin: 20px 0;
            border-radius: 20px;
            box-shadow: 4px 4px 8px #ff842b;
        }

        .pembayaran h1 {
            color: #fff;
            padding: 20px;
            font-size: 34px;
            font-weight: 700;
        }

        .pembayaran h2{
            color: #c4c4c4;
            padding: 0 40px;
            font-size: 24px;
        }

        .desc > h6{
            color: #fff;
        }

        .desc > h3{
            color: #ff842b;
            margin-top: 30px;
        }

        .h5 {
            color: #e6e6e6;

        }


        /* tiket */

        .tiket {
            display: flex;
            flex-direction: column; 
            color: #fff;
        }

        .cont {
            background: linear-gradient(to bottom,
                #414141 0%,
                #414141 26%,
                #ecedef 26%,
                #ecedef 100%
            );
            height: 330px;
            float: left;
            position: relative;
            padding: 1em;
            margin-top: 40px;
            box-shadow: 2px 2px 5px #414141;
        }

        .card-left {
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
            width: 500px;
        }

        .card-right {
            width: 200px;
            border-left: 0.18em dashed #fff;
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        .card-right::before,
        .card-right::after {
            content: "";
            position: absolute;
            display: block;
            width: 0.9em;
            height: 0.9em;
            background-color: #fff;
            border-radius: 50%;
            left: -0.5em;
        }

        .card-right::before {
            top: -0.4em;
        }

        .card-right::after {
            bottom: -0.4em;
        }

        .cont > h1 {
            font-size: 35px;
            margin-top: 0;
        }

        .cont > h1 span {
            font-weight: normal;
        }

        .title,
        .name,
        .seat,
        .time {
            text-transform: uppercase;
            font-weight: normal;
        }

        .title > h2,
        .name > h2,
        .seat > h2,
        .time > h2 {
            font-size: 18px;
            color: #525252;
            margin: 0;
        }

        .title > h2 {
            color: #ff842b;
            font-weight: 700;
            font-size: 25px;
            padding-top: 10px;
            margin-bottom: 25px;
        }

        .title > span,
        .name > span,
        .seat > span,
        .time > span {
            font-size: 0.7em;
            color: #a2aeae;
            
        }

        .title {
            margin: 2em 0 0 0;
        }

        .name,
        .seat {
            margin: 0.7em 0 0 0;
        }

        .time {
            margin: 0.7em 0 0 1em;
        }

        .seat,
        .time {
            float: left;
        }

        .eye {
            position: relative;
            width: 2em;
            height: 1.5em;
            background: #fff;
            margin: 10px auto;
            border-radius: 1em/0.6em;
            z-index: 1;
        }

        .eye::before,
        .eye::after {
            content: "";
            display: block;
            position: absolute;
            border-radius: 50%;
        }

        .eye::before {
            width: 1em;
            background: #414141;
            height: 1em;
            z-index: 2;
            left: 8px;
            top: 4px;

        }

        .eye::after {
            width: 0.5em;
            height: 0.5em;
            background: #fff;
            z-index: 3;
            left: 12px;
            top: 8px;
        }

        .number {
            text-align: center;
            text-transform: uppercase;
        }

        .number > h3 {
            color: #ff842b;
            margin: 50px 0 0 0;
            font-size: 2.5em;
        }

        .number > span {
            display: block;
            color: #a2aeae;
        }


    </style>
@endsection

@section('container')
    @foreach ($order as $or)
    <div class="row">
        <div class="col-2">
            <img src="{{ Storage::url('public/film/'.$or->foto) }}" style="width: 200px; border-radius: 20px;">
        </div>
        <div class="col-10">

            {{-- judul header --}}
            <h1 class="mb-3 h1">{{ $or->namaFilm }}</h1>
            <h2 class="h2"><i class="fa-solid fa-list me-2"></i>Genre : {{ $or->genre }}</h2>
            <h2 class="h2"><i class="fa-solid fa-clock me-2"></i>Duration : {{ $or->durasi }}</h2>
            <h2 class="h2"><i class="fa-solid fa-house me-2"></i>Teater : {{ $or->teater }}</h2>
            <h2 class="h2"><i class="fa-solid fa-calendar-days me-2"></i>Broadcast date : {{ $or->tgl_tayang }}</h2>                  
            <h2 class="mb-5 h2"><i class="fa-solid fa-calendar-days me-2"></i>Schedule : {{ $or->jadwal }} WIB</h2>

            {{-- Detail pemesanan --}}

            <div class="detail-transaksi">
                <div class="col-9" style="float: left;">
                    <h1>Detail Order</h1>
                    <h2><i class="fa-solid fa-barcode me-2"></i>Booking Code : {{ $no }}</h2>
                    <div class="desc">
                        <p>Ticket Price : Rp. {{ number_format($or->harga,0,',','.') }}</p>
                        <p>Total Ticket : {{ $or->totaltiket }}</p>
                        <p>Service Fee : Rp. 4.000 X {{ $or->totaltiket }}</p>
                        <p>Payment Method : {{ $or->method }}</p>
                        <p>Payment Date : {{ $or->tgl_trans }}</p>
                    </div>

                    <h3><i class="fa-solid fa-dollar-sign"></i>  Total Cost : Rp. {{ number_format($or->totalCost,0,',','.') }}</h3>
                </div>
                <div class="col-3 mt-5" style="float: right;">
                    <h5 class="h5">QR Code Order : </h5>
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $no }}" style="max-width: 150px;" class="mt-4 rounded"  id="qrorder">
                </div>
            </div>

            {{-- Detail ticket 1 per 1 --}}

            @php
                $nour = 1
            @endphp

            @foreach ($tiket as $tic)            

            <div class="tiket" id="content">
                <div class="pre-tiket">
                    <div class="cont card-left">
                        <h1>TIP <span>Movie</span></h1>
                        <div class="title">
                            <h2>{{ $tic->idno_kursi }}</h2>
                        </div>
                        <div class="name">
                            <h2 style="font-weight: bold; font-size: 20px;">{{ $or->namaFilm }}</h2>
                            <span>film</span>
                        </div>
                        <div class="name">
                            <h2>{{ $or->teater }}</h2>
                            <span>teater</span>
                        </div>
                        <div class="seat">
                            <h2>{{ $or->jadwal }}</h2>
                            <span>time</span>
                        </div>
                        <div class="time">
                            <h2>{{ $or->tgl_tayang }}</h2>
                            <span>date</span>
                        </div>
                    </div>
                
                    <div class="cont card-right">
                        <div class="eye"></div>
                        <div class="number">
                            <h3>{{ $tic->no_kursi }}</h3>
                            <span>seat</span>
                            <div class="barcode">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $tic->idno_kursi }}" style="max-width: 100px; margin-top: 10px;" class="mt-4 rounded"  id="qrorder">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @endforeach

        </div>
    </div>

    @endforeach

    @foreach ($tiket as $tic)
    <script>
        const printBtn = document.getElementById('print');
        
        printBtn.addEventListener('click', function(){
            print();
        })
    </script>
    @endforeach

@endsection