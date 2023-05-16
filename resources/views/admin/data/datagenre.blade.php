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
        <h1 class="h3 mb-0 text-gray-800">Genre Data</h1>
        <button type="button" class="btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#tambah"><i class="fas fa-database fa-sm text-white-50"></i> Add Genre</button>
    </div>

    {{-- page row --}}
    <div class="row">
        <table class="table table-stripped mt-2">
            <thead class="table-secondary">
                <th>No</th>
                <th>Genre Name</th>
                <th colspan="2">Action</th>
            </thead>
            @php
                $no = 1;
            @endphp
            @foreach ($genre as $g)
                <tbody>
                    <td>{{ $no++ }}</td>
                    <td>{{ $g->nama }}</td>
                    <td>
                        <button class="btn btn-success btn-sm" data-bs-target="#edit{{ $g->id }}" data-bs-toggle="modal">Edit</button>
                    </td>
                    <td>
                        <button class="btn btn-danger btn-sm" data-bs-target="#hapus{{ $g->id }}" data-bs-toggle="modal">Delete</button>
                    </td>
                </tbody>
            @endforeach
        </table>
    </div>



    {{-- Modal Tambah --}}

    <div class="modal fade" id="tambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Genre</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/addgenre" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row">
                        <label class="mb-2">Genre Name</label>
                        <input type="text" class="form-control" name="nama" placeholder="Genre Name">
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

    @foreach ($genre as $g)
        <div class="modal fade" id="edit{{ $g->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Genre</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/editgenre" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="row">
                            <input type="hidden" name="id" value="{{ $g->id }}">
                            <label class="mb-2">Genre Name</label>
                            <input type="text" class="form-control" name="nama" placeholder="Genre Name" value="{{ $g->nama }}">
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

    {{-- modal hapus --}}

    @foreach ($genre as $g)
        <div class="modal fade" id="hapus{{ $g->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Are you sure you want to delete the data {{ $g->nama }}?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/hapusgenre" method="post" enctype="multipart/form-data">
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