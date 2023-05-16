@extends('admin.layout.navadmin')

@section('content')
    <!-- Page Heading -->
    @if (session()->has('berhasil'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('berhasil') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @error('username')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Data Failed!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @enderror
    @error('password')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Data Failed!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @enderror
    @error('nama')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Data Failed!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @enderror
    @error('email')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Data Failed!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @enderror
    @error('no')
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
        <h1 class="h3 mb-0 text-gray-800">Admin's Data</h1>
        <button type="button" class="btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#tambah"><i
                class="fas fa-database fa-sm text-white-50"></i> Add Admin</button>
    </div>

    {{-- page row --}}
    <div class="row">
        <table class="table table-stripped mt-2">
            <thead class="table-secondary">
                <th>No</th>
                <th>Username</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Photo</th>
                <th colspan="2">Action</th>
            </thead>
            @php
                $no = 1;
            @endphp
            @foreach ($admin as $a)
                <tbody>
                    <td>{{ $no++ }}</td>
                    <td>{{ $a->username }}</td>
                    <td>{{ $a->nama }}</td>
                    <td>{{ $a->email }}</td>
                    <td>{{ $a->no }}</td>
                    <td>
                        <img src="{{ Storage::url('public/admin/' . $a->foto) }}" width="100" class="rounded">
                    </td>
                    <td>
                        <button class="btn btn-success btn-sm" data-bs-target="#edit{{ $a->id }}"
                            data-bs-toggle="modal">Edit</button>
                    </td>
                    <td>
                        <button class="btn btn-danger btn-sm" data-bs-target="#hapus{{ $a->id }}"
                            data-bs-toggle="modal">Delete</button>
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
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Admin</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/addadmin" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="row">
                            <label class="mb-2">Photo</label>
                            <input type="file" name="foto" class="form-control">
                        </div>
                        <div class="row mt-3">
                            <label class="mb-2">Username</label>
                            <input type="text" class="form-control" name="username" placeholder="Username">
                        </div>
                        <div class="row mt-3">
                            <label class="mb-2">Full Name</label>
                            <input type="text" class="form-control" name="nama" placeholder="Name">
                        </div>
                        <div class="row mt-3">
                            <label class="mb-2">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Password">
                        </div>
                        <div class="row mt-3">
                            <label class="mb-2">Email</label>
                            <input type="text" class="form-control" name="email" placeholder="Email">
                        </div>
                        <div class="row mt-3">
                            <label class="mb-2">Phone Number</label>
                            <input type="text" class="form-control" name="no" placeholder="Phone">
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

    @foreach ($admin as $a)
        <div class="modal fade" id="edit{{ $a->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Admin</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/editadmin" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $a->id }}">
                        <input type="hidden" name="fotolama" value="{{ $a->foto }}">
                        <div class="modal-body p-4">
                            <div class="row">
                                <label class="mb-2">New Photo</label>
                                <input type="file" name="fotobaru" class="form-control">
                            </div>
                            <div class="row mt-3">
                                <label class="mb-2">Username</label>
                                <input type="text" class="form-control" name="username" placeholder="Username"
                                    value="{{ $a->username }}">
                            </div>
                            <div class="row mt-3">
                                <label class="mb-2">Full Name</label>
                                <input type="text" class="form-control" name="nama" placeholder="Name"
                                    value="{{ $a->nama }}">
                            </div>
                            <div class="row mt-3">
                                <label class="mb-2">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Password"
                                    value="{{ $a->password }}">
                            </div>
                            <div class="row mt-3">
                                <label class="mb-2">Email</label>
                                <input type="text" class="form-control" name="email" placeholder="Email"
                                    value="{{ $a->email }}">
                            </div>
                            <div class="row mt-3">
                                <label class="mb-2">Phone Number</label>
                                <input type="text" class="form-control" name="no" placeholder="Phone"
                                    value="{{ $a->no }}">
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

    @foreach ($admin as $a)
        <div class="modal fade" id="hapus{{ $a->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete Admin {{ $a->username }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/hapusadmin" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $a->id }}">
                        <input type="hidden" name="foto" value="{{ $a->foto }}">

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
