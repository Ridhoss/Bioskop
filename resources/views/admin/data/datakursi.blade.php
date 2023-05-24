@extends('admin.layout.navadmin')

@section('content')
    <!-- Page Heading -->
    @if (session()->has('berhasil'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('berhasil') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @error('no_kursi')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Data Failed!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @enderror
    @error('teater')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Data Failed!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @enderror

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Seat Data</h1>

        <div class="btn-clm">
            <button type="button" class="btn btn-sm btn-danger shadow-sm me-4" data-bs-toggle="modal" data-bs-target="#hapus"><i
                class="fas fa-trash fa-sm text-white-50"></i> Delete Data</button>
            <button type="button" class="btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#tambah"><i
                class="fas fa-database fa-sm text-white-50"></i> Add Data</button>
        </div>
    </div>

    {{-- page row --}}
    <div class="row">
        <table class="table table-stripped mt-2">
            <thead class="table-secondary">
                <th>No</th>
                <th>Seat Number</th>
                <th>Teater</th>
                <th>Status</th>
                <th>Action</th>
            </thead>
            @php
                $no = 1;
            @endphp
            @foreach ($kursi as $f)
                <tbody>
                    <td>{{ $no++ }}</td>
                    <td>{{ $f->no_kursi }}</td>
                    <td>{{ $f->teater }}</td>
                    <td>
                        <form action="/statusSeat" method="post">
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
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Seat Teater</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/addSeat" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="row">
                            <label class="mb-2">Enter the number of seats</label>
                            <input type="text" class="form-control" name="no_kursi" placeholder="Number of seats" required>
                        </div>
                        <div class="row mt-3">
                            <label class="mb-2">Teater</label>
                            <select name="teater" class="form-select" required>
                                @foreach ($teater as $t)
                                    <option value="{{ $t->nama }}">{{ $t->nama }}</option>
                                @endforeach
                            </select>
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

    @foreach ($kursi as $k)
        <div class="modal fade" id="edit{{ $k->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Seat Teater</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/editSeat" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $k->id }}">
                        <div class="modal-body p-4">
                            <div class="row">
                                <label class="mb-2">Seat Number | Format : X1</label>
                                <input type="text" class="form-control" name="no_kursi" placeholder="Seat Number"
                                    value="{{ $k->no_kursi }}">
                            </div>
                            <div class="row mt-3">
                                <label class="mb-2">Teater</label>
                                <input type="text" class="form-control" name="teater" placeholder="Seat Number"
                                    value="{{ $k->teater }}">
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

    {{-- Modal Hapus --}}

    @foreach ($kursi as $f)
        <div class="modal fade" id="hapus" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Remove all seats</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/hapusSeat" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body p-4">
                            <div class="row">
                                <label class="mb-2">Teater</label>
                                <select name="teater" class="form-select" required>
                                    @foreach ($teater2 as $t)
                                        <option value="{{ $t->nama }}">{{ $t->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
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
