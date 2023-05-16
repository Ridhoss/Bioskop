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
    @error('genre')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Data Failed!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @enderror
    @error('durasi')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Data Failed!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @enderror
    @error('deskripsi')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Data Failed!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @enderror
    @error('foto')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Data Failed!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @enderror
    @error('fotobaru')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Data Failed!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @enderror

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Film Data</h1>
        <button type="button" class="btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#tambah"><i class="fas fa-database fa-sm text-white-50"></i> Add Data</button>
    </div>

    {{-- page row --}}
    <div class="row">
        <table class="table table-stripped mt-2">
            <thead class="table-secondary">
                <th>No</th>
                <th>Name</th>
                <th>Genre</th>
                <th>Duration</th>
                <th>Description</th>
                <th>Image</th>
                <th>Status</th>
                <th colspan="2">Action</th>
            </thead>
            @php
                $no = 1;
            @endphp
            @foreach ($film as $f)
                <tbody>
                    <td>{{ $no++ }}</td>
                    <td>{{ $f->nama }}</td>
                    <td>{{ $f->genre }}</td>
                    <td>{{ $f->durasi }}</td>
                    <td>{{ $f->deskripsi }}</td>
                    <td>
                        <img src="{{ Storage::url('public/film/'. $f->foto) }}" style="width: 100px; border-radius: 20px">
                    </td>
                    <td>
                        <form action="/statusfilm" method="post">
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
                        <button class="btn btn-success btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#edit{{ $f->id }}">Edit</button>
                    </td>
                    <td>
                        <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#hapus{{ $f->id }}">Delete</button>
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
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Film</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/addfilm" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row">
                        <label class="mb-2">Name</label>
                        <input type="text" class="form-control" name="nama" placeholder="Film Name" required>
                    </div>
                    <div class="row mt-3">
                        <label class="mb-2">Genre</label>
                        {{-- <select name="genre" class="form-select">
                            @foreach ($genre as $g)
                                <option value="{{ $g->nama }}">{{ $g->nama }}</option>
                            @endforeach
                        </select> --}}
                        <input type="text" class="form-control" name="genre" placeholder="Film Genre" required>
                    </div>
                    <div class="row mt-3">
                        <label class="mb-2">Duration, Format : -h -min</label>
                        <input type="text" class="form-control" name="durasi" placeholder="Film Duration" required>
                    </div>
                    <div class="row mt-3">
                        <label class="mb-2">Description | Max: 100</label>
                        <textarea name="deskripsi" class="form-control" placeholder="Film Description" required></textarea>
                    </div>
                    <div class="row mt-3">
                        <label class="mb-2">Image</label>
                        <input type="file" name="foto" class="form-control">
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


    {{-- MODAL EDIT --}}

    @foreach ($film as $f)
        
    <div class="modal fade" id="edit{{ $f->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Film {{ $f->nama }}</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/editfilm" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $f->id }}">
                <input type="hidden" name="fotolama" value="{{ $f->foto }}">
                <div class="modal-body p-4">
                    <div class="row">
                        <label class="mb-2">Name</label>
                        <input type="text" class="form-control" name="nama" placeholder="Film Name" value="{{ $f->nama }}">
                    </div>
                    <div class="row mt-3">
                        <label class="mb-2">Genre</label>
                        {{-- <select name="genre" class="form-select">
                            @foreach ($genre as $g)
                                <option value="{{ $g->nama }}">{{ $g->nama }}</option>
                            @endforeach
                        </select> --}}
                        <input type="text" class="form-control" name="genre" placeholder="Film Genre" value="{{ $f->genre }}">
                    </div>
                    <div class="row mt-3">
                        <label class="mb-2">Duration, Format : -h -min</label>
                        <input type="text" class="form-control" name="durasi" placeholder="Film Duration" value="{{ $f->durasi }}">
                    </div>
                    <div class="row mt-3">
                        <label class="mb-2">Description | Max: 100</label>
                        <textarea name="deskripsi" class="form-control" placeholder="Film Description">{{ $f->deskripsi }}</textarea>
                    </div>
                    <div class="row mt-3">
                        <label class="mb-2">Image</label>
                        <input type="file" name="fotobaru" class="form-control">
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

    @foreach ($film as $f)
        
    <div class="modal fade" id="hapus{{ $f->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete Film {{ $f->nama }}</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/hapusfilm" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $f->id }}">
                <input type="hidden" name="foto" value="{{ $f->foto }}">

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