@extends('admin.layout.navadmin')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- User Data -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 ms-2">
                                User Data</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 ms-2">{{ $user }}</div>
                        </div>
                        <div class="col-auto me-3">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Film Data -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1 ms-2">
                                Film Data</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 ms-2">{{ $film }}</div>
                        </div>
                        <div class="col-auto me-3">
                            <i class="fas fa-film fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Teater Data -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1 ms-2">
                                Teater Data</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 ms-2">{{ $teater }}</div>
                        </div>
                        <div class="col-auto me-3">
                            <i class="fa-solid fa-location-dot fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Data -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1 ms-2">
                                Admin Data</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 ms-2">{{ $admin }}</div>
                        </div>
                        <div class="col-auto me-3">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">

        <div class="col-lg-12 mb-4">

            <!-- Recent Transactions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Transactions</h6>
                </div>
                <div class="card-body">
                    <table class="table table-stripped">
                        <thead>
                            <th>No</th>
                            <th>Order Number</th>
                            <th>User</th>
                            <th>Film</th>
                            <th>Schedule</th>
                            <th>Teater</th>
                            <th>Broadcast Date</th>
                            <th>Order quantity</th>
                        </thead>
                        @php
                            $no = 1;
                        @endphp
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
                            </tbody>
                        @endforeach
                    </table>
                </div>
            </div>


        </div>

        <div class="col-lg-12 mb-4">

            <!-- Active Seat -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Seats Active</h6>
                </div>
                <div class="card-body">
                    <table class="table table-stripped mt-2">
                        <thead>
                            <th>No</th>
                            <th>Order Number</th>
                            <th>Ticket Number</th>
                            <th>Seat Number</th>
                            <th>Status</th>
                        </thead>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($kursi as $f)
                            <tbody>
                                <td>{{ $no++ }}</td>
                                <td>{{ $f->no_order }}</td>
                                <td>{{ $f->idno_kursi }}</td>
                                <td>{{ $f->no_kursi }}</td>
                                <td>
                                    <form action="/statusDetailDash" method="post">
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
                            </tbody>
                        @endforeach
                    </table>
                </div>
            </div>


        </div>

    </div>
@endsection