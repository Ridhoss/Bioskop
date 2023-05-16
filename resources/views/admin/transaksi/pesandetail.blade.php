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
    <h1 class="h3 mb-0 text-gray-800">Detail Order Data</h1>
    {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
    </div>

    {{-- page row --}}
    <div class="row">
    <table class="table table-stripped mt-2">
        <thead class="table-secondary">
            <th>No</th>
            <th>Order Number</th>
            <th>Ticket Number</th>
            <th>Seat Number</th>
            <th>Price</th>
            <th>Status</th>
            <th colspan="2">Action</th>
        </thead>
        @php
            $no = 1;
        @endphp
        @foreach ($pesan as $f)
            <tbody>
                <td>{{ $no++ }}</td>
                <td>{{ $f->no_order }}</td>
                <td>{{ $f->idno_kursi }}</td>
                <td>{{ $f->no_kursi }}</td>
                <td>Rp. {{ number_format($f->harga, 0,',','.') }}</td>
                <td>
                    <form action="/statusDetail" method="post">
                        @csrf
                        <input type="hidden" value="{{ $f->id }}" name="id">
                        @if ($f->status == '0')
                            <input type="hidden" value="1" name="go">
                            <button type="submit" class="btn btn-secondary btn-sm">Inactive</button>
                        @elseif($f->status == '1')
                            <input type="hidden" value="0" name="go">
                            <button type="submit" class="btn btn-primary btn-sm">Active</button>
                        @endif
                    </form>
                </td>
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
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Are you sure?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/hapusdetail" method="post" enctype="multipart/form-data">
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