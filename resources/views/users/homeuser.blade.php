@extends('users.layout.navbar')

@section('container')

    <div class="movie" id="mov">
        <div class="glider-contain" id="glide">
            <div class="glider p-3" id="in-glide">
                @if ($count == 0)
                    <h5 class="text-center mt-5">Data Not Found.</h5>
                    <h5 class="text-center mt-5">Data Not Found.</h5>
                    <h5 class="text-center mt-5">Data Not Found.</h5>
                    <h5 class="text-center mt-5">Data Not Found.</h5>
                @else
                    @foreach ($film as $f)
                        <a href="/desc/{{ $f->id }}" class="isi">
                            <div class="isi-movie">
                                <img src="{{ Storage::url('public/film/' . $f->foto) }}" class="mb-3">
                                <h1>{{ $f->nama }}</h1>
                            </div>
                        </a>
                    @endforeach
                @endif

            </div>

            <button aria-label="Previous" class="glider-prev" id="btn">«</button>
            <button aria-label="Next" class="glider-next" id="btn">»</button>

        </div>
    </div>

    <div class="news" id="news">
        <h1 class="mt-5 mb-5">TIP NEWS</h1>

        @foreach ($news as $n)
            <div class="card mb-4">
                <div class="row g-0">
                    <div class="col-md-2">
                        <img src="{{ Storage::url('public/news/' . $n->foto) }}" class="img-fluid rounded-start"
                            style="width: 200px;">
                    </div>
                    <div class="col-md-10">
                        <div class="card-body">
                            <h5 class="card-title mb-3">{{ $n->judul }}</h5>
                            <p class="card-text">{{ $n->deskripsi }}</p>
                            <p class="card-text"><small class="text-body-secondary">Uploaded : {{ $n->data_rilis }}</small></p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach


    </div>
@endsection
