@extends('admin.layout.navadmin')

@section('style')
    <style>
        @media print {

            #accordionSidebar,
            #content-wrapper,
            #nav,
            #act {
                display: none;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Page Heading -->
    @if (session()->has('berhasil'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('berhasil') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        {{-- <form class="d-flex mt-2" role="search" action="/order">
            @csrf
            <input class="form-control me-2" type="search" placeholder="Search Order Number" aria-label="Search"
                name="cari" value="{{ request('cari') }}">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form> --}}

        <h1 class="h3 mb-0 text-gray-800">Order Data</h1>
        <a class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="printin"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    {{-- Page Row --}}

    <div class="row" id="row">
        <table id="myTable" class="display">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Order Number</th>
                    <th>User</th>
                    <th>Film</th>
                    <th>Schedule</th>
                    <th>Teater</th>
                    <th>Broadcast Date</th>
                    <th>Order quantity</th>
                    <th>Total Price</th>
                    <th id="act">Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp
                @foreach ($pesan as $f)
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
                        <td id="act">
                            <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal"
                                data-bs-target="#hapus{{ $f->id }}">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- <table class="table table-stripped mt-2" id="table">
            <thead class="table-secondary">
                <th>No</th>
                <th>Order Number</th>
                <th>User</th>
                <th>Film</th>
                <th>Schedule</th>
                <th>Teater</th>
                <th>Broadcast Date</th>
                <th>Order quantity</th>
                <th colspan="2" id="act">Action</th>
            </thead>
            @php
                $no = 1;
            @endphp
            @if ($count == 0)
                <tbody>
                    <td>Data Not Found</td>
                    <td>Data Not Found</td>
                    <td>Data Not Found</td>
                    <td>Data Not Found</td>
                    <td>Data Not Found</td>
                    <td>Data Not Found</td>
                    <td>Data Not Found</td>
                    <td>Data Not Found</td>
                    <td id="act">Data Not Found</td>
                </tbody>
            @else
                @foreach ($pesan as $f)
                    <tbody>
                        <td>{{ $no++ }}</td>
                        <td>{{ $f->no_order }}</td>
                        <td>{{ $f->username }}</td>
                        <td>{{ $f->film }}</td>
                        <td>{{ $f->start }}</td>
                        <td>{{ $f->nama }}</td>
                        <td>{{ $f->jadwal_tgl }}</td>
                        <td>{{ $f->jml_kursi }}</td>
                        <td id="act">
                            <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal"
                                data-bs-target="#hapus{{ $f->id }}">Delete</button>
                        </td>
                    </tbody>
                @endforeach
            @endif
        </table> --}}
    </div>


    {{-- modal hapus --}}

    @foreach ($pesan as $g)
        <div class="modal fade" id="hapus{{ $g->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Are you sure you want to delete
                            {{ $g->no_order }}?</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/hapuspesan" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $g->id }}">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        const printBtn = document.getElementById('printin');

        printBtn.addEventListener('click', function() {
            print();
        })
    </script>

    <script>
        $(document).ready(function() {
            new DataTable("#myTable");
        });
    </script>
@endsection
