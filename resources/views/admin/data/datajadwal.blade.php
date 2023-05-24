@extends('admin.layout.navadmin')

@section('content')
    <!-- Page Heading -->
    @if (session()->has('berhasil'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('berhasil') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @error('start')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Data Failed!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @enderror
    @error('end')
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
        <h1 class="h3 mb-0 text-gray-800">Schedule Data</h1>
        <button type="button" class="btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#tambah"><i
                class="fas fa-database fa-sm text-white-50"></i> Add Data</button>
    </div>

    {{-- page row --}}
    <div class="row">
        <table class="table table-stripped mt-2">
            <thead class="table-secondary">
                <th>No</th>
                <th>Time Start</th>
                <th>Time End</th>
                <th>Teater</th>
                <th>Status</th>
                <th colspan="2">Action</th>
            </thead>
            @php
                $no = 1;
            @endphp
            @foreach ($schedule as $f)
                <tbody>
                    <td>{{ $no++ }}</td>
                    <td>{{ $f->start }}</td>
                    <td>{{ $f->end }}</td>
                    <td>{{ $f->teater }}</td>
                    <td>
                        <form action="/statusschedule" method="post">
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
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Schedule</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/addschedule" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="row">
                            <label class="mb-2">Start Time</label>
                            <input type="text" class="form-control" name="start" placeholder="Start Time Schedule" required>
                        </div>
                        <div class="row mt-3">
                            <label class="mb-2">End Time</label>
                            <input type="text" class="form-control" name="end" placeholder="End Time Schedule" required>
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

    @foreach ($schedule as $t)
        <div class="modal fade" id="edit{{ $t->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Schedule</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/editschedule" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $t->id }}">
                        <div class="modal-body p-4">
                            <div class="row">
                                <label class="mb-2">Start Time</label>
                                <input type="text" class="form-control" name="start"
                                    placeholder="Start Time Schedule" value="{{ $t->start }}">
                            </div>
                            <div class="row mt-3">
                                <label class="mb-2">End Time</label>
                                <input type="text" class="form-control" name="end"
                                    placeholder="End Time Schedule" value="{{ $t->end }}">
                            </div>
                            <div class="row mt-3">
                                <label class="mb-2">Teater</label>
                                <input type="text" class="form-control" name="teater" placeholder="Schedule Teater"
                                    value="{{ $t->teater }}">
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

    @foreach ($schedule as $f)
        <div class="modal fade" id="hapus{{ $f->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete Schedule</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/hapusschedule" method="post" enctype="multipart/form-data">
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
