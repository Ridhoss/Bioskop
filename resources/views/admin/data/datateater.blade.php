@extends('admin.layout.navadmin')

@section('content')
    <!-- Page Heading -->
    @if (session()->has('berhasil'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('berhasil') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @error('nama')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Data Failed!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @enderror
    @error('harga')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Data Failed!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @enderror


    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Teater Data</h1>
        <button type="button" class="btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#tambah"><i
                class="fas fa-database fa-sm text-white-50"></i> Add Data</button>
    </div>

    {{-- page row --}}
    <div class="row">
        <table class="table table-stripped mt-2">
            <thead class="table-secondary">
                <th>No</th>
                <th>Teater Name</th>
                <th>Price</th>
                <th>Status</th>
                <th colspan="2">Action</th>
            </thead>
            @php
                $no = 1;
            @endphp
            @foreach ($teater as $f)
                <tbody>
                    <td>{{ $no++ }}</td>
                    <td>{{ $f->nama }}</td>
                    <td>Rp. {{ number_format($f->harga, 0, ',', '.') }}</td>
                    <td>
                        <form action="/statusteater" method="post">
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
                        <button class="btn btn-success btn-sm" type="button" data-bs-toggle="modal"
                            data-bs-target="#edit{{ $f->id }}">Edit</button>
                    </td>
                    <td>
                        <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal"
                            data-bs-target="#hapus{{ $f->id }}">Delete</button>
                    </td>
                </tbody>
            @endforeach
        </table>
    </div>


    {{-- Modal Tambah --}}

    <div class="modal fade" id="tambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Teater</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/addteater" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="row">
                            <label class="mb-2">Name</label>
                            <input type="text" class="form-control" name="nama" placeholder="Teater Name" required>
                        </div>
                        <div class="row mt-3">
                            <label class="mb-2">Price</label>
                            <input type="text" class="form-control" name="harga" placeholder="Ticket Price" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- Modal Edit --}}

    @foreach ($teater as $t)
        <div class="modal fade" id="edit{{ $t->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Teater</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/editteater" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $t->id }}">
                        <div class="modal-body p-4">
                            <div class="row">
                                <label class="mb-2">Name</label>
                                <input type="text" class="form-control" name="nama" placeholder="Teater Name"
                                    value="{{ $t->nama }}">
                            </div>
                            <div class="row mt-3">
                                <label class="mb-2">Price</label>
                                <input type="text" class="form-control" name="harga" placeholder="Ticket Price"
                                    value="{{ $t->harga }}">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($teater as $f)
        <div class="modal fade" id="hapus{{ $f->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete Teater</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/hapusteater" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $f->id }}">

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
