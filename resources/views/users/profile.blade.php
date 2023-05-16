<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>

    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">

    <!-- ICON -->
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>

    {{-- bootstrap --}}
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    {{-- vanilla --}}
    <style>
        body {
            margin-top: 20px;
            color: #1a202c;
            text-align: left;
            background-color: #eaddcd;
        }

        .main-body {
            padding: 15px;
        }

        .card {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 0 solid rgba(0, 0, 0, .125);
            border-radius: .25rem;
        }

        .card-body {
            flex: 1 1 auto;
            min-height: 1px;
            padding: 1rem;
        }

        .gutters-sm {
            margin-right: -8px;
            margin-left: -8px;
        }

        .gutters-sm>.col,
        .gutters-sm>[class*=col-] {
            padding-right: 8px;
            padding-left: 8px;
        }

        .mb-3,
        .my-3 {
            margin-bottom: 1rem !important;
        }

        .bg-gray-300 {
            background-color: #e2e8f0;
        }

        .h-100 {
            height: 100% !important;
        }

        .shadow-none {
            box-shadow: none !important;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="main-body">
            <!-- /Breadcrumb -->

            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                @if ($user->gambar == null)
                                    <img src="assets/img/profile.png" alt="Admin" class="rounded-circle"
                                        width="150">
                                @else
                                    <img src="{{ Storage::url('public/users/') . $user->gambar }}" alt="Admin"
                                        class="rounded-circle" width="150">
                                @endif
                                <div class="mt-3">
                                    <h4 class="mb-4">{{ $user->username }}</h4>
                                    <a href="/home" class="btn btn-secondary">Back</a>
                                    <button class="btn btn-outline-danger" type="button" data-bs-target="#logout"
                                        data-bs-toggle="modal">Logout</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <a href="https://github.com/Ridhoss" target="blank"
                                    class="text-decoration-none d-flex justify-content-between align-items-center flex-wrap text-body-secondary">
                                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-github me-2 icon-inline">
                                            <path
                                                d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22">
                                            </path>
                                        </svg>Github</h6>
                                    <span class="text-secondary">Ridhoss</span>
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="https://twitter.com/RidhoSulistyo13" target="blank"
                                    class="text-decoration-none d-flex justify-content-between align-items-center flex-wrap text-body-secondary">
                                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-twitter me-2 icon-inline text-info">
                                            <path
                                                d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z">
                                            </path>
                                        </svg>Twitter</h6>
                                    <span class="text-secondary">RidhoSulistyo13</span>
                                </a>
                            </li>
                            <li class="list-group-item ">
                                <a href="https://www.instagram.com/riidhooss" target="blank"
                                    class="text-decoration-none d-flex justify-content-between align-items-center flex-wrap text-body-secondary">
                                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-instagram me-2 icon-inline text-danger">
                                            <rect x="2" y="2" width="20" height="20"
                                                rx="5" ry="5"></rect>
                                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                                        </svg>Instagram</h6>
                                    <span class="text-secondary">riidhooss</span>
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="https://www.facebook.com/ridho.sulistyo.948" target="blank"
                                    class="text-decoration-none d-flex justify-content-between align-items-center flex-wrap text-body-secondary">
                                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-facebook me-2 icon-inline text-primary">
                                            <path
                                                d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z">
                                            </path>
                                        </svg>Facebook</h6>
                                    <span class="text-secondary">Ridho Sulistyo</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Name</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ $user->name }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Email</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ $user->email }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Phone</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ $user->no_hp }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <a class="btn btn-success" type="button" data-bs-target="#edit"
                                        data-bs-toggle="modal">Edit</a>
                                    <a class="btn btn-primary" type="button" data-bs-target="#password"
                                        data-bs-toggle="modal">Edit Password</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (session()->has('berhasilbio'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Data Successfully changed!
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session()->has('berhasilpass'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Password Successfully changed!
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    @error('NewImage')
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Data Failed!</strong> {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @enderror
                    @error('username')
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Data Failed!</strong> {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @enderror
                    @error('nama')
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Data Failed!</strong> {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @enderror
                    @error('email')
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Data Failed!</strong> {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @enderror
                    @error('no')
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Data Failed!</strong> {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @enderror
                    @error('old_password')
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Data Failed!</strong> {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @enderror
                    @error('new_password')
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Data Failed!</strong> {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @enderror

                </div>
            </div>

        </div>
    </div>

    <!-- Modal edit -->
    <div class="modal fade" id="edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Personal Information</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="/editprofile" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            {{-- hidden --}}
                            <input type="hidden" name="gambarlama" value="{{ $user->gambar }}">
                            <input type="hidden" name="id" value="{{ $user->id }}">

                            <label style="font-weight: 600;">Profile Photo</label>
                            <input type="file" class="form-control mt-2 @error('NewImage') is-invalid @enderror"
                                style="width: 300px;" name="NewImage">
                            @error('NewImage')
                                <div>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="row mt-3">
                            <label style="font-weight: 600;">Username</label>
                            <input type="text" class="form-control mt-2 @error('username') is-invalid @enderror"
                                style="width: 300px;" placeholder="Username" name="username"
                                value="{{ $user->username }}">
                        </div>
                        <div class="row mt-3">
                            <label style="font-weight: 600;">Name</label>
                            <input type="text" class="form-control mt-2 @error('nama') is-invalid @enderror"
                                style="width: 300px;" placeholder="Full Name" name="nama"
                                value="{{ $user->name }}">
                        </div>
                        <div class="row mt-3">
                            <label style="font-weight: 600;">Email</label>
                            <input type="text" class="form-control mt-2 @error('email') is-invalid @enderror"
                                style="width: 300px;" placeholder="Email" name="email"
                                value="{{ $user->email }}">
                        </div>
                        <div class="row mt-3">
                            <label style="font-weight: 600;">Phone</label>
                            <input type="text" class="form-control mt-2 @error('no') is-invalid @enderror"
                                style="width: 300px;" placeholder="Phone" name="no"
                                value="{{ $user->no_hp }}">
                        </div>
                </div>
                <div class="modal-footer">
                    <a href="" class="btn btn-secondary" data-bs-dismiss="modal">Close</a>
                    <button type="submit" class="btn btn-success">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal password -->
    <div class="modal fade" id="password" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Password</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="/editpassword" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <div class="row">
                            <label style="font-weight: 600;">Current Password</label>
                            <input type="password" class="form-control mt-2 @error('password') is-invalid @enderror"
                                style="width: 300px;" placeholder="Current Password" name="old_password"
                                value="" required>
                        </div>
                        <div class="row mt-3">
                            <label style="font-weight: 600;">New Password</label>
                            <input type="password" class="form-control mt-2 @error('newpass') is-invalid @enderror"
                                style="width: 300px;" placeholder="New Password" name="new_password" value=""
                                required>
                        </div>
                        <div class="row mt-3">
                            <label style="font-weight: 600;">New Password Verify</label>
                            <input type="password" class="form-control mt-2 @error('newpassver') is-invalid @enderror"
                                style="width: 300px;" placeholder="New Password, again"
                                name="new_password_confirmation" value="" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <a href="" class="btn btn-secondary" data-bs-dismiss="modal">Close</a>
                    <button type="submit" class="btn btn-success">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- modal logout --}}

    <div class="modal fade" id="logout" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Are you sure?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-footer">
                    <a href="" class="btn btn-secondary" data-bs-dismiss="modal">Close</a>
                    <form action="/logout" method="post">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- bootstrap js --}}
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>

</body>

</html>
