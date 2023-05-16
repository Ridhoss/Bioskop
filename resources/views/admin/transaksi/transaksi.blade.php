@extends('admin.layout.navadmin')

@section('content')
    <!-- Page Heading -->
    @if (session()->has('berhasil'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('berhasil') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Transcation Data</h1>
    {{-- <button type="button" class="btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#tambah"><i class="fas fa-database fa-sm text-white-50"></i> Add Data</button> --}}
    </div>

    {{-- page row --}}
    <div class="row">
    <table class="table table-stripped mt-2">
        <thead class="table-secondary">
            <th>No</th>
            <th>Order Number</th>
            <th>Transaction Date</th>
            <th>Payment Method</th>
            <th>Total</th>
            <th>Phone</th>
            <th colspan="2">Action</th>
        </thead>
        @php
            $no = 1;
        @endphp
        @foreach ($pesan as $f)
            <tbody>
                <td>{{ $no++ }}</td>
                <td>{{ $f->no_order }}</td>
                <td>{{ $f->tgl_trans }}</td>
                <td>{{ $f->metode }}</td>
                <td>Rp. {{ number_format($f->total, 0,',','.') }}</td>
                <td>{{ $f->no_hp }}</td>
                <td>
                    <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#hapus{{ $f->id }}">Delete</button>
                </td>
            </tbody>
        @endforeach
    </table>
    </div>

    {{-- modal hapus --}}

    @foreach ($pesan as $g)
        <div class="modal fade" id="hapus{{ $g->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Are you sure you want to delete transcation?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/hapustransaksi" method="post" enctype="multipart/form-data">
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
@endsection