<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>

    <!-- FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@500&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@600&display=swap" rel="stylesheet">

    <!-- ICON -->
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <script src="https://kit.fontawesome.com/904a972631.js" crossorigin="anonymous"></script>

    {{-- bootstrap --}}
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!-- GLIDER -->
    <link rel="stylesheet" href="assets/css/glider.min.css">

    {{-- vanilla --}}
    <style>
        * {
            /* font-family: 'Poppins', sans-serif; */
            font-family: 'IBM Plex Sans', sans-serif;
            /* font-family: 'Comfortaa', cursive; */
        }

        .profile {
            color: #fff;
        }

        .prof {
            text-decoration: none;
        }

        .gambarprof {
            width: 75px;
        }

        .card-img-top {
            width: 150px;
        }

        /* slider */

        #glide {
            margin-top: 40px;
            height: 450px;
        }

        #in-glide {
            height: 450px;
        }

        #btn {
            margin-top: 35px;
            font-size: 50px;
            color: #141412;
        }

        #btn:hover {
            color: #ff842b;
        }


        /* isi */

        .isi {
            text-decoration: none;
        }

        .isi-movie {
            width: 200px;
            height: 294px;
            margin: 30px;
        }

        .isi-movie img {
            width: 200px;
            border-radius: 20px;
            box-shadow: 0 0 2px 2px #272727;
            transition: 0.4s;
        }

        .isi-movie img:hover {
            box-shadow: 0 0 4px 6px #ff842b;
            transform: translateY(-10px);
        }

        .isi-movie h1 {
            font-size: 20px;
            margin-left: 10px;
            text-transform: uppercase;
            color: #2a3a45;
        }

        .movie,
        .news {
            width: 90%;
        }

        body::-webkit-scrollbar {
            display: none;
        }

        /* footer */

        .footer {
            width: 100%;
            height: 70px;
            display: block;
            position: absolute;
            background-color: #141412;
        }

        .footer h1 {
            font-size: 20px;
            text-align: center;
            color: #fff;
            padding-top: 25px;
        }

        .nav-link {
            position: relative;
        }

        .nav-link:hover {
            /* text-decoration: underline;
            border-bottom: 2px solid greenyellow; */
        }

        .nav-link::after {
            content: '';
            background-color: #ff842b;
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            border-radius: 2px;
            width: 100%;
            opacity: 0;
            transition: all 0.3s;
        }

        .nav-link:hover::after {
            opacity: 1;
        }
    </style>

    @yield('style')

</head>

<body>

    <nav class="navbar navbar-expand-lg" data-bs-theme="dark" style="background-color: #2e2e2e">
        <div class="container-fluid">
            <a class="navbar-brand fs-4 fw-bold mb-2" href="/home">
                TIP MOVIE</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse mb-2" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-5">
                    <li class="nav-item">
                        <a class="nav-link active fs-5" aria-current="page" href="/home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fs-5" href="/home#news" aria-current="page">News</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fs-5" href="/ticket" aria-current="page">Ticket</a>
                    </li>
                    <li class="nav-item ms-4">
                        <form class="d-flex mt-2" role="search" action="/home">
                            @csrf
                            <input class="form-control me-2" type="search" placeholder="Search Film"
                                aria-label="Search" name="cari" value="{{ request('cari') }}">
                            <button class="btn btn-success" type="submit">Search</button>
                        </form>
                    </li>
                </ul>
                <a href="/profile" class="prof">
                    <div class=" d-flex mt-1">
                        <h4 class="profile mt-4 fw-semibold" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ $user->username }}</h4>
                        @if ($user->gambar == null)
                            <img src="/assets/img/profile.png" class="gambarprof ms-3 me-4 mt-1 rounded-circle">
                        @else
                            <img src="{{ Storage::url('public/users/') . $user->gambar }}"
                                class="gambarprof ms-3 me-4 mt-1 rounded-circle">
                        @endif
                    </div>
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid ms-5 mt-5">

        @yield('container')

    </div>

    <img src="/assets/img/wave.svg" alt="">

    <div class="footer">
        <h1>Copyright &copy; Ridho Sulistyo.S TIP Movie 2023</h1>
    </div>

    {{-- bootstrap js --}}
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>

    {{-- glider --}}
    <script src="assets/js/glider.min.js"></script>

    <script>
        new Glider(document.querySelector('.glider'), {
            slidesToShow: 4,
            dots: '#dots',
            arrows: {
                prev: '.glider-prev',
                next: '.glider-next'
            }
        });
    </script>

</body>

</html>
