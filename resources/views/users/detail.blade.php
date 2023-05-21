@extends('users.layout.navbar')

@section('style')
    <style>
        .col-10 > h1 {
            font-weight: 700;
            text-transform: uppercase;
        }

        .col-10 > h2 {
            font-size: 18px;
            font-weight: 600;
            color: #6e6e6e;
        }

        /* detail transaksi */

        .detail-transaksi {
            width: 90%;
            height: 350px;
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
            height: 100%;
            background-color: #414141;
            margin: 20px 0;
            border-radius: 20px;
            box-shadow: 4px 4px 8px #ff842b;
        }

        .pembayaran h1 {
            color: #fff;
            padding: 25px;
            font-size: 34px;
            font-weight: 700;
        }

        /* radio */


        .radio {
            font-size: 20px;
            font-weight: 600;
            text-transform: capitalize;
            display: inline-block;
            vertical-align: middle;
            margin: 20px 20px 20px 45px;
            position: relative;
            padding-left: 35px;
            padding-top: 5px;
            padding-bottom: 5px;
            padding-right: 10px;
            cursor: pointer;
            color: #414141;
            transition: 0.5s;
            border: 2px solid #eaddcd;
            border-radius: 10px;
            background-color: #e6e6e6;
            box-shadow: 2px 2px 2px #000;
        }

        .radio:hover {
            color: #7a7a7a;
        }

        .radio input[type="radio"]{
            display: none;
        }

        .radio span{
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 3px solid #414141;
            display: block;
            position: absolute;
            left: 3px;
            top: 10.3px;

        }

        .radio span:after{
            content: "";
            height: 8px;
            width: 8px;
            background-color: #414141;
            display: block;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%) scale(0);
            border-radius: 50%;
            transition: 0.2s ease-in-out 0s;

        }

        .radio input[type="radio"]:checked ~ span:after{
            transform: translate(-50%, -50%) scale(1.5);
        }



        /* input text */

        .name p{
            color: #e6e6e6;
            font-size: 18px;
            margin-left: 10px;
            margin-top: 15px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .name { 
            padding-left: 40px;
        }

        .name input {
            margin-left: 10px;
            width: 180px;
            height: 30px;
        }

        .input-name {
            display: flex;
            border: 2px outset #ddd;
            margin: auto 0;
            height: 40px;
            line-height: 30px;
            max-width: 300px;
            width: 100%;
            background-color: #fff;
            border-radius: 20px;
        }

        .input-name > i {
            padding-left: 20px;
            margin-top: 4px;
            line-height: 32px;
            opacity: 50%;
        }

        .input-name input{
            border: none;
            outline: none;
            background-color: #fff;
            height: 100%;
            padding: 0 10px;
            font-size: 15px;
            width: 600px;
            border-radius: 20px;

        }

    </style>
@endsection

@section('container')
<div class="row">
    <div class="col-2">
        <img src="{{ Storage::url('public/film/'.$film->foto) }}" style="width: 200px; border-radius: 20px;">
    </div>
    <div class="col-10">
        <h1 class="mb-3">{{ $film->nama }}</h1>
        <h2><i class="fa-solid fa-list me-2"></i>Genre : {{ $film->genre }}</h2>
        <h2><i class="fa-solid fa-clock me-2"></i>Duration : {{ $film->durasi }}</h2>
        <h2><i class="fa-solid fa-house me-2"></i>Teater : {{ $teater->nama }}</h2>        
        <h2 class="fw-bold"><i class="fa-solid fa-dollar-sign me-2"></i>Price : Rp. {{ number_format($teater->harga, 0, ',' ,'.') }}</h2>
        <h2><i class="fa-solid fa-calendar-days me-2"></i>Broadcast date : {{ $tanggal }}</h2>           
        <h2 class="mb-5"><i class="fa-solid fa-calendar-days me-2"></i>Schedule : {{ $jadwal->start }} - {{ $jadwal->end }}</h2>

        <form action="/go" method="post">
            @csrf

            @php
                
                $today = date('Ymd');
                $randomNumber = rand(0, 999);

                    $custom = "TIP".$today.str_pad($randomNumber, 3, '0', STR_PAD_LEFT).$user->id;

                $total = $teater->harga * $jumlah;

                    $total2 = $jumlah * 4000;

                    $sub = $total + $total2;

            @endphp

            <div class="detail-transaksi">
                <h1>Detail Transaksi</h1>
                <h2>Order Number : {{ $custom }}</h2>
                <div class="desc">
                    <p>Seat Number : {{ $seat }}</p>
                    <p>Ticket Price : Rp. {{ number_format($teater->harga, 0, ',' ,'.') }} X {{ $jumlah }}</p>
                    <p>Service Fee : Rp. 4.000 X {{ $jumlah }}</p>
                </div>

                <!-- send data -->

                <input type="hidden" name="user" value="{{ $user->id }}">
                <input type="hidden" name="film" value="{{ $film->id }}">
                <input type="hidden" name="tanggal" value="{{ $tanggal }}">
                <input type="hidden" name="teater" value="{{ $teater->id }}">
                <input type="hidden" name="jadwal" value="{{ $jadwal->id }}">
                <input type="hidden" name="no_order" value="{{ $custom }}">
                @foreach ($kursi as $k)
                    <input type="hidden" name="kursi[]" value="{{ $k }}">
                @endforeach
                <input type="hidden" name="total" value="{{ $sub }}">

                <h3><i class="fa-solid fa-dollar-sign"></i>  Total Cost : Rp. {{ number_format($sub, 0, ',' ,'.') }}</h3>
            </div>

            <div class="pembayaran">
                <h1>Payment Method</h1>

                @foreach ($metode as $m)
                    <label class="radio">
                        <input type="radio" value="{{ $m->id }}" name="metode" required>
                        <i class="fa-solid fa-circle-dollar-to-slot"></i>
                        {{ $m->nama }}
                        <span></span>
                    </label>
                @endforeach
                
                <div class="name" id="page">
                    <p>Enter your phone number</p>
                        <div class="input-name">
                            <i class="fa-solid fa-phone"></i>
                            <input type="text" name="phone" placeholder="Phone Number" required>
                        </div>
                
                    <button class="btn btn-warning my-4 btn-md" type="submit">Go Book</button>

                </div>
                
            </div>

    </div>

</form>

</div>
@endsection