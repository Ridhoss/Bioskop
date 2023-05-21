<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TIP Movie Report</title>

    {{-- bootstrap --}}
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<body onafterprint="window.location='/order'">

    <div class="container">
        <h1 class="text-center mt-5">TIP MOVIE</h1>
        <p class="text-center">Jl. H. Bakar, Utama, Kec. Cimahi Sel., Kota Cimahi, Jawa Barat 40521</p>

        <div class="row mt-5">
            <p>Date : {{ $start }} / {{ $end }}</p>
            <table class="table table-striped">
                <thead>
                    <th>No</th>
                    <th>Order Number</th>
                    <th>User</th>
                    <th>Film</th>
                    <th>Schedule</th>
                    <th>Teater</th>
                    <th>Broadcast Date</th>
                    <th>Order quantity</th>
                    <th>Total Price</th>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($data as $f)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $f->no_order }}</td>
                            <td>{{ $f->username }}</td>
                            <td>{{ $f->film }}</td>
                            <td>{{ $f->start }}</td>
                            <td>{{ $f->nama }}</td>
                            <td>{{ $f->jadwal_tgl }}</td>
                            <td>{{ $f->jml_kursi }}</td>
                            <td>Rp. {{ number_format($f->total, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        window.print();
    </script>

</body>

</html>
