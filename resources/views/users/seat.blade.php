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

        /* seat-pick */

        .seat-pick {
            width: 90%;
            height: 500px;
            background-color: #414141;
            margin: 20px 0;
            display: flex;
            border-radius: 20px;
            box-shadow: 4px 4px 8px #ff842b;
        }

        .seat-pick h1 {
            color: #fff;
            font-size: 30px;
            margin-left: 50px;
            margin-top: 30px;
        }

        .seat {
            display: flex;
            flex-wrap: wrap;
            width: 380px;
            margin: 20px 40px;
        }

        .seat label i {
            font-size: 40px;
            padding: 15px;
            color: #e6e6e6;
            transition: 0.3s;
            cursor: pointer;
        }

        #i0 {
            color: #eb243b;
        }

        .seat label input:checked~i {
            color: #ff842b;
        }

        .seat input[type="checkbox"] {
            -webkit-appearance: none;
            visibility: hidden;
            display: none;
        }

        /* info */

        .desc-info {
            margin-top: 20px;
            width: 300px;
            padding-left: 50px;
            padding: 10px;
            border-radius: 20px;
            box-shadow: 2px 2px 0 #e6e6e6;
            background-color: #e6e6e6;
        }

        .desc-info p {
            font-size: 18px;
            color: #272727;
            font-weight: 500;
            padding: 5px;
            display: flex;
        }

        #note {
            font-size: 12px;
            color: #eb243b;
            font-weight: 600;
        }
        
        .Layar {
            width: 330px;
            height: 30px;
            text-align: center;
            background-color: #fff; 
            border-radius: 10px;
            padding: 2px;
            font-weight: bold;
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
            <h2 class="fw-bold"><i class="fa-solid fa-dollar-sign me-2"></i>Price : Rp.
                {{ number_format($teater->harga, 0, ',', '.') }}</h2>
            <h2><i class="fa-solid fa-calendar-days me-2"></i>Broadcast date : {{ $tanggal }}</h2>
            <h2 class="mb-5"><i class="fa-solid fa-calendar-days me-2"></i>Schedule : {{ $jadwal->start }} -
                {{ $jadwal->end }}</h2>

            <form action="/detail" method="post">
                @csrf
                <input type="hidden" name="film" value="{{ $film->id }}">
                <input type="hidden" name="teater" value="{{ $teater->id }}">
                <input type="hidden" name="jadwal" value="{{ $jadwal->id }}">
                <input type="hidden" name="tanggal" value="{{ $tanggal }}">

                <div class="seat-pick">

                    <h1>Pick Seat :</h1>

                    <div class="seat">


                        @foreach ($seat as $s)
                            @php
                                $status = 1;
                            @endphp

                            @foreach ($pesan as $pes)
                                @if ($s->id == $pes->id_kursi)
                                    @php
                                        $status = 0;
                                    @endphp
                                @endif
                            @endforeach

                            @if ($status == 1)
                                <label>
                                    <input type="checkbox" value="{{ $s->no_kursi }}" name="kursi[]">
                                    <i class="fa-solid fa-chair" id="i{{ $status }}"></i>
                                </label>
                            @else
                                <label>
                                    <i class="fa-solid fa-chair" id="i{{ $status }}"></i>
                                </label>
                            @endif
                        @endforeach

                    <div class="Layar">
                        Cinema Screen
                    </div>

                    </div>


                    <div class="info">

                        <h1>Price Details :</h1>

                        <div class="desc-info">
                            <p id="jml-tiket">Jumlah Tiket : 0</p>
                            <p id="no-kursi">Nomor Kursi : </p>
                            <p id="ttl-hrga">Total Harga : Rp. 0</p>
                        </div>

                        <div class="button">
                            <button class="btn btn-warning mt-4" style="float: right" type="submit">Book</button>
                        </div>

                    </div>

                </div>

        </div>
    </div>

    </form>


    <script>
        // JavaScript code to handle seat selection
        const selectedSeats = {};
        const maxSeats = 100;

        // Add a change event listener to each seat checkbox
        document.querySelectorAll('.seat-pick input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', () => {

                const seatId = checkbox.value;
                const isSeatAvailable = checkbox.checked;

                // Check if the maximum number of seats has been reached
                if (isSeatAvailable && Object.keys(selectedSeats).length >= maxSeats) {
                    // If the maximum number of seats has been reached, uncheck the checkbox
                    checkbox.checked = false;
                    return;
                }

                // Perbarui objek Kursi yang dipilih untuk mencerminkan pilihan
                if (isSeatAvailable) {
                    selectedSeats[seatId] = true;
                } else {
                    delete selectedSeats[seatId];
                }

                // Calculate the total pick of the selected seat

                const totalPick = Object.keys(selectedSeats).length + 0;
                document.getElementById('jml-tiket').textContent = 'Jumlah Tiket : ' + totalPick;

                // Display the selected seats to the user
                const selectedSeatsList = Object.keys(selectedSeats).join(', ');
                document.getElementById('no-kursi').textContent = 'Nomor Kursi : ' + selectedSeatsList;

                // Calculate the total cost of the selected seats
                const totalCost = Object.keys(selectedSeats).length * {{ $teater->harga }};
                document.getElementById('ttl-hrga').textContent = 'Total Harga : Rp. ' + totalCost
                    .toLocaleString('id-ID');
            });
        });
    </script>
@endsection
