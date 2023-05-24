<?php

namespace App\Http\Controllers;

use App\Models\admin;
use App\Models\detailpesan;
use App\Models\film;
use App\Models\genre;
use App\Models\jadwal;
use App\Models\kursi;
use App\Models\metode;
use App\Models\news;
use App\Models\pesan;
use App\Models\teater;
use App\Models\transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use SebastianBergmann\Type\VoidType;

class AdminController extends Controller
{

    // ke halaman login
    public function HalamanLog()
    {
        return view('admin.loginadmin', [
            'title' => 'Login | Admin'
        ]);
    }

    // ke dashboard
    public function Dashboard()
    {
        return view('admin.dashboard', [
            'title' => 'Dashboard | Admin',
            'film' => DB::table('films')->count(),
            'user' => DB::table('users')->count(),
            'teater' => DB::table('teaters')->count(),
            'admin' => DB::table('admins')->count(),
            'bio' => Auth::user(),
            'pesan' => pesan::select('pesans.id', 'pesans.no_order', 'pesans.jadwal_tgl', 'users.username', 'films.nama AS film', 'jadwals.start', 'teaters.nama', 'pesans.jml_kursi')
                ->join('users', 'users.id', '=', 'pesans.id_user')
                ->join('films', 'films.id', '=', 'pesans.id_film')
                ->join('jadwals', 'jadwals.id', '=', 'pesans.id_jadwal')
                ->join('teaters', 'teaters.id', '=', 'pesans.id_teater')
                ->get(),
            'kursi' => detailpesan::select('detailpesans.id', 'detailpesans.idno_kursi', 'detailpesans.no_order', 'kursis.no_kursi', 'detailpesans.harga', 'detailpesans.status')
                ->join('kursis', 'kursis.id', '=', 'detailpesans.id_kursi')
                ->where('detailpesans.status', '=', '1')
                ->get()
        ]);
    }


    // LOGIN LOGOUT

    // login
    // public function Login(Request $request)
    // {
    //     $login = $request->validate([
    //         'username'=>'required',
    //         'password'=>'required'
    //     ]);

    //     if (Auth::guard('admin')->attempt($login)) {
    //         $request->session()->regenerate();

    //         return redirect()->intended('/dashboard');
    //     }

    //     return back()->with('gallog', 'login gagal');

    // }
    // logout
    // public function Logout(Request $request)
    // {
    //     Auth::guard('admin')->logout();

    //     return redirect()->intended('/admin');
    // }


    // FILM

    // ke halaman data film
    public function Film()
    {
        return view('admin.data.datafilm', [
            'title' => 'Data Film | Admin',
            'genre' => genre::all(),
            'film' => film::all(),
            'bio' => Auth::user()
        ]);
    }
    // tambah film
    public function AddFilm(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nama' => 'required|unique:films|regex:/^[a-zA-z0-9\s]*$/',
            'genre' => 'required',
            'durasi' => 'required|regex:/^[a-zA-z0-9\s]*$/',
            'deskripsi' => 'required',
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect('/film')
                ->withErrors($validator);
        }

        // upload gambar
        $foto = $request->file('foto');
        $foto->storeAs('public/film', $foto->hashName());

        film::create([
            'nama' => $request->nama,
            'genre' => $request->genre,
            'durasi' => $request->durasi,
            'deskripsi' => $request->deskripsi,
            'foto' => $foto->hashName(),
            'status' => '0'
        ]);

        return redirect()->intended('/film')->with('berhasil', 'Data has been successfully uploaded');
    }
    // ganti status film
    public function StatusFilm(Request $request)
    {
        $data = film::find($request->id);

        $data->update([
            'status' => $request->go
        ]);

        return redirect()->intended('/film');
    }
    // edit data film
    public function EditFilm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|unique:films|regex:/^[a-zA-z0-9\s]*$/',
            'genre' => 'required',
            'durasi' => 'required|regex:/^[a-zA-z0-9\s]*$/',
            'deskripsi' => 'required',
            'fotobaru' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect('/film')
                ->withErrors($validator);
        }

        if ($request->hasFile('fotobaru')) {

            // upload gambar baru
            $gambar = $request->file('fotobaru');
            $gambar->storeAs('public/film', $gambar->hashName());

            // menghapus gambar lama
            Storage::delete('public/film/' . $request->fotolama);

            $film = film::find($request->id);

            // update produk lama dengan produk yang baru
            $film->update([
                'nama' => $request->nama,
                'genre' => $request->genre,
                'durasi' => $request->durasi,
                'deskripsi' => $request->deskripsi,
                'foto' => $gambar->hashName()
            ]);
        } else {
            // update produk tanpa gambar

            $film = film::find($request->id);

            $film->update([
                'nama' => $request->nama,
                'genre' => $request->genre,
                'durasi' => $request->durasi,
                'deskripsi' => $request->deskripsi,
            ]);
        }

        return redirect()->intended('/film')->with('berhasil', 'Data has been succesfully updated');
    }
    // Hapus Data film
    public function HapusFilm(Request $request)
    {
        // menghapus gambar
        Storage::delete('public/film/' . $request->foto);

        // menghapus produk
        $film = film::find($request->id);
        $film->delete();

        return redirect()->intended('/film')->with('berhasil', 'Data has been succesfully deleted');
    }


    // GENRE

    // ke halaman genre
    public function Genre()
    {
        return view('admin.data.datagenre', [
            'title' => 'Data Genre | Admin',
            'genre' => genre::all(),
            'bio' => Auth::user()
        ]);
    }
    // tambah genre
    public function AddGenre(Request $request)
    {

        $request->validate([
            'nama' => 'required|unique:genres'
        ]);

        genre::insert([
            'nama' => $request->nama
        ]);

        return redirect()->intended('/genre')->with('berhasil', 'Data has been successfully added.');
    }
    // edit genre
    public function EditGenre(Request $request)
    {
        $request->validate([
            'nama' => 'required'
        ]);

        $data = genre::find($request->id);

        $data->update([
            'nama' => $request->nama
        ]);

        return redirect()->intended('/genre')->with('berhasil', 'Data has ben succesfully updated.');
    }
    // Hapus Genre
    public function HapusGenre(Request $request)
    {
        $request->validate([
            "id" => 'required'
        ]);

        $data = genre::find($request->id);

        $data->delete();

        return redirect()->intended('/genre')->with('berhasil', 'Data has ben succesfully deleted.');
    }



    // NEWS

    // ke halaman news
    public function News()
    {
        return view('admin.data.datanews', [
            'title' => 'Data News | Admin',
            'news' => news::all(),
            'bio' => Auth::user()
        ]);
    }
    // tambah data news
    public function AddNews(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|unique:news',
            'rilis' => 'required',
            'deskripsi' => 'required',
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect('/news')
                ->withErrors($validator);
        }

        // upload gambar
        $foto = $request->file('foto');
        $foto->storeAs('public/news', $foto->hashName());

        news::create([
            'judul' => $request->judul,
            'data_rilis' => $request->rilis,
            'deskripsi' => $request->deskripsi,
            'foto' => $foto->hashName(),
            'status' => '0'
        ]);

        return redirect()->intended('/news')->with('berhasil', 'Data has been successfully uploaded');
    }
    // ganti status news
    public function StatusNews(Request $request)
    {
        $data = news::find($request->id);

        $data->update([
            'status' => $request->go
        ]);

        return redirect()->intended('/news');
    }
    // edit data news
    public function EditNews(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|unique:news',
            'rilis' => 'required',
            'deskripsi' => 'required',
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect('/news')
                ->withErrors($validator);
        }

        if ($request->hasFile('foto')) {

            // upload gambar baru
            $gambar = $request->file('foto');
            $gambar->storeAs('public/news', $gambar->hashName());

            // menghapus gambar lama
            Storage::delete('public/news/' . $request->fotolama);

            $film = news::find($request->id);

            // update produk lama dengan produk yang baru
            $film->update([
                'judul' => $request->judul,
                'data_rilis' => $request->rilis,
                'deskripsi' => $request->deskripsi,
                'foto' => $gambar->hashName()
            ]);
        } else {
            // update produk tanpa gambar

            $film = news::find($request->id);

            $film->update([
                'judul' => $request->judul,
                'data_rilis' => $request->rilis,
                'deskripsi' => $request->deskripsi
            ]);
        }

        return redirect()->intended('/news')->with('berhasil', 'Data has been succesfully updated');
    }
    // Hapus Data news
    public function HapusNews(Request $request)
    {
        // menghapus gambar
        Storage::delete('public/news/' . $request->foto);

        // menghapus news
        $film = news::find($request->id);
        $film->delete();

        return redirect()->intended('/news')->with('berhasil', 'Data has been succesfully deleted');
    }


    // TEATER

    // ke halaman teater
    public function Teater()
    {
        return view('admin.data.datateater', [
            'title' => 'Data Teater | Admin',
            'teater' => teater::all(),
            'bio' => Auth::user()
        ]);
    }
    // Tambah data teater
    public function AddTeater(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|regex:/^[a-zA-z0-9\s]*$/|unique:teaters',
            'harga' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect('/teater')
                ->withErrors($validator);
        }

        teater::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'status' => '0'
        ]);

        return redirect()->intended('/teater')->with('berhasil', 'Data has been successfully uploaded');
    }
    // ganti status teater
    public function StatusTeater(Request $request)
    {
        $data = teater::find($request->id);

        $data->update([
            'status' => $request->go
        ]);

        return redirect()->intended('/teater');
    }
    // edit data teater
    public function EditTeater(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|regex:/^[a-zA-z0-9\s]*$/|unique:teaters',
            'harga' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect('/teater')
                ->withErrors($validator);
        }

        // update produk tanpa gambar

        $teater = teater::find($request->id);

        $teater->update([
            'nama' => $request->nama,
            'harga' => $request->harga,
        ]);

        return redirect()->intended('/teater')->with('berhasil', 'Data has been succesfully updated');
    }
    // hapus data teater
    public function HapusTeater(Request $request)
    {
        // menghapus teater
        $film = teater::find($request->id);
        $film->delete();

        return redirect()->intended('/teater')->with('berhasil', 'Data has been succesfully deleted');
    }


    // JADWAL

    // ke halaman jadwal
    public function Jadwal()
    {
        return view('admin.data.datajadwal', [
            'title' => 'Data Jadwal | Admin',
            'schedule' => jadwal::all(),
            'bio' => Auth::user(),
            'teater' => teater::all()
        ]);
    }
    // tambah jadwal
    public function AddSchedule(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start' => 'required',
            'end' => 'required',
            'teater' => 'required',
            'start' => [
                'required',
                Rule::unique('jadwals')->where(function ($query) use ($request) {
                    return $query->where('start', $request->start)
                        ->where('end', $request->end)
                        ->where('teater', $request->teater);
                })
            ]

        ]);

        if ($validator->fails()) {
            return redirect('/schedule')
                ->withErrors($validator);
        }

        jadwal::create([
            'start' => $request->start,
            'end' => $request->end,
            'teater' => $request->teater,
            'status' => '0'
        ]);

        return redirect()->intended('/schedule')->with('berhasil', 'Data has been successfully uploaded');
    }
    // ubah status
    public function StatusSchedule(Request $request)
    {
        $data = jadwal::find($request->id);

        $data->update([
            'status' => $request->go
        ]);

        return redirect()->intended('/schedule');
    }
    // update schedule
    public function EditSchedule(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start' => 'required',
            'end' => 'required',
            'teater' => 'required',
            'start' => [
                'required',
                Rule::unique('jadwals')->where(function ($query) use ($request) {
                    return $query->where('start', $request->start)
                        ->where('end', $request->end)
                        ->where('teater', $request->teater);
                })
            ]
        ]);

        if ($validator->fails()) {
            return redirect('/schedule')
                ->withErrors($validator);
        }

        $data = jadwal::find($request->id);

        $data->update([
            'start' => $request->start,
            'end' => $request->end,
            'teater' => $request->teater
        ]);

        return redirect()->intended('/schedule')->with('berhasil', 'Data has been succesfully updated');
    }
    // Hapus Schedule
    public function HapusSchedule(Request $request)
    {
        // menghapus schedule
        $film = jadwal::find($request->id);
        $film->delete();

        return redirect()->intended('/schedule')->with('berhasil', 'Data has been succesfully deleted');
    }




    // DATA ADMIN


    // Ke halaman data admin
    public function AdminData()
    {
        return view('admin.data.dataadmin', [
            'title' => 'Data Admin | Admin',
            'admin' => admin::all(),
            'bio' => Auth::user()
        ]);
    }
    // Tambah admin
    public function AddAdmin(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'username' => 'required|regex:/^[a-zA-z\s]*$/|unique:admins',
            'password' => 'required',
            'nama' => 'required|regex:/^[a-zA-z\s]*$/',
            'email' => 'required|email:dns',
            'no' => 'required|numeric',
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect('/admindata')
                ->withErrors($validator);
        }

        // hashing password
        $request['password'] = Hash::make($request['password']);

        // upload gambar
        $foto = $request->file('foto');
        $foto->storeAs('public/admin', $foto->hashName());

        admin::create([
            'username' => $request->username,
            'password' => $request['password'],
            'nama' => $request->nama,
            'email' => $request->email,
            'foto' => $foto->hashName(),
            'no' => $request->no
        ]);

        if ($request->hasFile('foto')) {

            // upload gambar
            $foto = $request->file('foto');
            $foto->storeAs('public/admin', $foto->hashName());

            admin::create([
                'username' => $request->username,
                'password' => $request['password'],
                'nama' => $request->nama,
                'email' => $request->email,
                'foto' => $foto->hashName(),
                'no' => $request->no
            ]);
        } else {
            // tambah admin tanpa gambar

            admin::create([
                'username' => $request->username,
                'password' => $request['password'],
                'nama' => $request->nama,
                'email' => $request->email,
                'no' => $request->no
            ]);
        }

        return redirect()->intended('/admindata')->with('berhasil', 'Data has been successfully uploaded');
    }
    // Edit Admin
    public function EditAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|regex:/^[a-zA-z\s]*$/|unique:admins',
            'password' => 'required',
            'nama' => 'required|regex:/^[a-zA-z\s]*$/',
            'email' => 'required|email:dns',
            'no' => 'required|numeric',
            'fotobaru' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect('/admindata')
                ->withErrors($validator);
        }

        // hashing password
        $request['password'] = Hash::make($request['password']);

        if ($request->hasFile('fotobaru')) {

            // upload gambar baru
            $gambar = $request->file('fotobaru');
            $gambar->storeAs('public/admin', $gambar->hashName());

            // menghapus gambar lama
            Storage::delete('public/admin/' . $request->fotolama);

            $admin = admin::find($request->id);

            // update produk lama dengan produk yang baru
            $admin->update([
                'username' => $request->username,
                'password' => $request['password'],
                'nama' => $request->nama,
                'email' => $request->email,
                'foto' => $gambar->hashName(),
                'no' => $request->no
            ]);
        } else {
            // update produk tanpa gambar

            $admin = admin::find($request->id);

            $admin->update([
                'username' => $request->username,
                'password' => $request['password'],
                'nama' => $request->nama,
                'email' => $request->email,
                'no' => $request->no
            ]);
        }

        return redirect()->intended('/admindata')->with('berhasil', 'Data has been succesfully updated');
    }
    // Hapus Admin
    public function HapusAdmin(Request $request)
    {
        // menghapus gambar
        Storage::delete('public/admin/' . $request->foto);

        // menghapus produk
        $admin = admin::find($request->id);
        $admin->delete();

        return redirect()->intended('/admindata')->with('berhasil', 'Data has been succesfully deleted');
    }




    // DATA USER

    // Ke Halaman Data User
    public function UserData()
    {
        return view('admin.data.datauser', [
            'title' => 'Data User | Admin',
            'user' => User::all(),
            'bio' => Auth::user()
        ]);
    }
    // Tambah user
    public function AddUser(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'username' => 'required|regex:/^[a-zA-z\s]*$/|unique:users',
            'password' => 'required|min:5',
            'nama' => 'required|regex:/^[a-zA-z\s]*$/',
            'email' => 'required|email:dns',
            'no' => 'required|numeric',
            'foto' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect('/userdata')
                ->withErrors($validator);
        }

        // hashing password
        $request['password'] = Hash::make($request['password']);

        if ($request->hasFile('foto')) {

            /// upload gambar
            $foto = $request->file('foto');
            $foto->storeAs('public/users', $foto->hashName());

            User::create([
                'username' => $request->username,
                'password' => $request['password'],
                'name' => $request->nama,
                'email' => $request->email,
                'gambar' => $foto->hashName(),
                'no_hp' => $request->no
            ]);
        } else {
            // update produk tanpa gambar

            User::create([
                'username' => $request->username,
                'password' => $request['password'],
                'name' => $request->nama,
                'email' => $request->email,
                'no_hp' => $request->no
            ]);
        }

        return redirect()->intended('/userdata')->with('berhasil', 'Data has been successfully uploaded');
    }
    // Edit User
    public function EditUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|regex:/^[a-zA-z\s]*$/|unique:users',
            'password' => 'required|min:5',
            'nama' => 'required|regex:/^[a-zA-z\s]*$/',
            'email' => 'required|email:dns',
            'no' => 'required|numeric',
            'fotobaru' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect('/userdata')
                ->withErrors($validator);
        }

        // hashing password
        $request['password'] = Hash::make($request['password']);

        if ($request->hasFile('fotobaru')) {

            // upload gambar baru
            $gambar = $request->file('fotobaru');
            $gambar->storeAs('public/users', $gambar->hashName());

            // menghapus gambar lama
            Storage::delete('public/users/' . $request->fotolama);

            $admin = User::find($request->id);

            // update produk lama dengan produk yang baru
            $admin->update([
                'username' => $request->username,
                'password' => $request['password'],
                'name' => $request->nama,
                'email' => $request->email,
                'gambar' => $gambar->hashName(),
                'no_hp' => $request->no
            ]);
        } else {
            // update produk tanpa gambar

            $admin = User::find($request->id);

            $admin->update([
                'username' => $request->username,
                'password' => $request['password'],
                'name' => $request->nama,
                'email' => $request->email,
                'no_hp' => $request->no
            ]);
        }

        return redirect()->intended('/userdata')->with('berhasil', 'Data has been succesfully updated');
    }
    // Hapus User
    public function HapusUser(Request $request)
    {
        // menghapus gambar
        Storage::delete('public/users/' . $request->foto);

        // menghapus produk
        $admin = User::find($request->id);
        $admin->delete();

        return redirect()->intended('/userdata')->with('berhasil', 'Data has been succesfully deleted');
    }





    // Data Kursi

    // kehalaman data kursi
    public function SeatData()
    {
        return view('admin.data.datakursi', [
            'title' => 'Data Kursi | Admin',
            'bio' => Auth::user(),
            'kursi' => kursi::select('*')
                ->orderBy('teater')
                ->get(),
            'teater' => teater::select('*')
                ->where('status', '=', '1')
                ->get()
        ]);
    }
    // Add Seat
    public function AddSeat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_kursi' => 'required',
            'teater' => 'required|regex:/^[a-zA-z0-9\s]*$/',
            'no_kursi' => [
                'required',
                Rule::unique('kursis')->where(function ($query) use ($request) {
                    return $query->where('no_kursi', $request->no_kursi)
                        ->where('teater', $request->teater);
                })
            ]
        ]);

        if ($validator->fails()) {
            return redirect('/seatdata')
                ->withErrors($validator);
        }

        $seats = [];
        $huruf = 'A';
        $angka = 1;
        $jml = $request->no_kursi;

        for ($i = 1; $i <= $jml; $i++) {
            $seat = $huruf . $angka;
            $seats[] = $seat;

            // Periksa jika angka sudah mencapai 5, ganti huruf dengan huruf berikutnya
            if ($angka >= 5) {
                $huruf++;
                $angka = 1;
            } else {
                $angka++;
            }
        }

        $trt = teater::select('*')
            ->where('nama', '=', $request->teater)
            ->get();

        foreach ($trt as $t) {
            $ttr = teater::find($t->id);

            $ttr->update([
                'status' => '0'
            ]);
        }

        foreach ($seats as $seat) {
            kursi::create([
                'no_kursi' => $seat,
                'teater' => $request->teater,
                'status' => '1'
            ]);
        }

        return redirect()->intended('/seatdata')->with('berhasil', 'Data has been successfully uploaded');
    }
    // Edit Seat
    public function EditSeat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_kursi' => 'required',
            'teater' => 'required|regex:/^[a-zA-z0-9\s]*$/',
            'no_kursi' => [
                'required',
                Rule::unique('kursis')->where(function ($query) use ($request) {
                    return $query->where('no_kursi', $request->no_kursi)
                        ->where('teater', $request->teater);
                })
            ]
        ]);

        if ($validator->fails()) {
            return redirect('/seatdata')
                ->withErrors($validator);
        }

        $data = kursi::find($request->id);

        $data->update([
            'no_kursi' => $request->no_kursi,
            'teater' => $request->teater,
        ]);

        return redirect()->intended('/seatdata')->with('berhasil', 'Data has been succesfully updated');
    }
    // ubah status
    public function StatusSeat(Request $request)
    {
        $data = kursi::find($request->id);

        $data->update([
            'status' => $request->go
        ]);

        return redirect()->intended('/seatdata');
    }
    // Hapus kursi
    public function HapusSeat(Request $request)
    {
        // menghapus schedule

        $kursi = kursi::select('*')
            ->where('teater', '=', $request->teater)
            ->get();

        $trt = teater::select('*')
            ->where('nama', '=', $request->teater)
            ->get();

        foreach ($trt as $t) {
            $ttr = teater::find($t->id);

            $ttr->update([
                'status' => '1'
            ]);
        }

        foreach ($kursi as $kur) {
            $krs = kursi::find($kur->id);
            $krs->delete();
        }

        return redirect()->intended('/seatdata')->with('berhasil', 'Data has been succesfully deleted');
    }



    // Data Metode

    // ke halaman metode
    public function MetodeData()
    {
        return view('admin.data.datametode', [
            'title' => 'Data Metode | Admin',
            'bio' => Auth::user(),
            'metode' => metode::all()
        ]);
    }
    // Add metode
    public function AddMetode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|unique:metodes|regex:/^[a-zA-z\s]*$/',
        ]);

        if ($validator->fails()) {
            return redirect('/Metode')
                ->withErrors($validator);
        }

        metode::create([
            'nama' => $request->nama,
            'status' => '0'
        ]);

        return redirect()->intended('/Metode')->with('berhasil', 'Data has been successfully uploaded');
    }
    // Edit Metode
    public function EditMetode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|unique:metodes|regex:/^[a-zA-z\s]*$/',
        ]);

        if ($validator->fails()) {
            return redirect('/Metode')
                ->withErrors($validator);
        }

        $data = metode::find($request->id);

        $data->update([
            'nama' => $request->nama,
        ]);

        return redirect()->intended('/Metode')->with('berhasil', 'Data has been succesfully updated');
    }
    // // ubah status
    public function StatusMetode(Request $request)
    {
        $data = metode::find($request->id);

        $data->update([
            'status' => $request->go
        ]);

        return redirect()->intended('/Metode');
    }
    // // Hapus Schedule
    public function HapusMetode(Request $request)
    {
        // menghapus schedule
        $film = metode::find($request->id);
        $film->delete();

        return redirect()->intended('/Metode')->with('berhasil', 'Data has been succesfully deleted');
    }




    // TRANSAKSI

    // ORDER

    // Ke halaman order
    public function Order()
    {

        $pesan = pesan::select('pesans.id', 'pesans.no_order', 'pesans.jadwal_tgl', 'users.username', 'films.nama AS film', 'jadwals.start', 'teaters.nama', 'pesans.jml_kursi', 'transaksis.total')
            ->join('users', 'users.id', '=', 'pesans.id_user')
            ->join('films', 'films.id', '=', 'pesans.id_film')
            ->join('jadwals', 'jadwals.id', '=', 'pesans.id_jadwal')
            ->join('teaters', 'teaters.id', '=', 'pesans.id_teater')
            ->join('transaksis', 'transaksis.no_order', '=', 'pesans.no_order')
            ->orderBy('pesans.created_at', 'desc');

        if (request('cari')) {
            $pesan->where('no_order', 'like', '%' . request('cari') . '%');
        }


        return view('admin.transaksi.datapesan', [
            'title' => 'Order Data | Admin',
            'bio' => Auth::user(),
            'pesan' => $pesan->get(),
            'count' => pesan::select('*')
                ->count(),
            'user' => User::all()
        ]);
    }
    // // Hapus order
    public function HapusPesan(Request $request)
    {
        // menghapus schedule
        $film = pesan::find($request->id);
        $film->delete();

        return redirect()->intended('/order')->with('berhasil', 'Data has been succesfully deleted');
    }



    // DETAIL ORDER

    // Ke halaman detail order
    public function DetailOrder()
    {
        return view('admin.transaksi.pesandetail', [
            'title' => 'Detail Order | Admin',
            'bio' => Auth::user(),
            'pesan' => detailpesan::select('detailpesans.id', 'detailpesans.idno_kursi', 'detailpesans.no_order', 'kursis.no_kursi', 'detailpesans.harga', 'detailpesans.status')
                ->join('kursis', 'kursis.id', '=', 'detailpesans.id_kursi')
                ->get(),
        ]);
    }
    // // Hapus detail order
    public function HapusDetail(Request $request)
    {
        // menghapus schedule
        $film = detailpesan::find($request->id);
        $film->delete();

        return redirect()->intended('/detail-order')->with('berhasil', 'Data has been succesfully deleted');
    }
    // Ganti status detail
    public function StatusDetail(Request $request)
    {
        $data = detailpesan::find($request->id);

        $data->update([
            'status' => $request->go
        ]);

        return redirect()->intended('/detail-order');
    }
    // Ganti status detail dari dashborad
    public function StatusDetailDash(Request $request)
    {
        $data = detailpesan::find($request->id);

        $data->update([
            'status' => $request->go
        ]);

        return redirect()->intended('/dashboard');
    }




    // DETAIL ORDER

    // Ke halaman detail order
    public function Transaction()
    {
        return view('admin.transaksi.transaksi', [
            'title' => 'Transaction | Admin',
            'bio' => Auth::user(),
            'pesan' => transaksi::select('transaksis.id', 'transaksis.no_order', 'transaksis.tgl_trans', 'metodes.nama AS metode', 'transaksis.total', 'transaksis.no_hp')
                ->join('metodes', 'metodes.id', '=', 'transaksis.metode')
                ->get()
        ]);
    }
    // Hapus transaksi
    public function HapusTransaksi(Request $request)
    {
        // menghapus schedule
        $film = transaksi::find($request->id);
        $film->delete();

        return redirect()->intended('/transcation')->with('berhasil', 'Data has been succesfully deleted');
    }


    // Laporan

    public function Laporan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Start' => 'required',
            'End' => 'required',
        ]);

        $validatorname = Validator::make($request->all(), [
            'username' => 'required'
        ]);

        if ($validator->fails() && $validatorname->fails()) {

            $data = pesan::select('pesans.id', 'pesans.no_order', 'pesans.jadwal_tgl', 'users.username', 'films.nama AS film', 'jadwals.start', 'teaters.nama', 'pesans.jml_kursi', 'transaksis.total')
                ->join('users', 'users.id', '=', 'pesans.id_user')
                ->join('films', 'films.id', '=', 'pesans.id_film')
                ->join('jadwals', 'jadwals.id', '=', 'pesans.id_jadwal')
                ->join('teaters', 'teaters.id', '=', 'pesans.id_teater')
                ->join('transaksis', 'transaksis.no_order', '=', 'pesans.no_order')
                ->orderBy('pesans.created_at', 'asc');

            $st = pesan::select('pesans.jadwal_tgl')
                ->orderBy('jadwal_tgl', 'asc')
                ->first();

            $en = pesan::select('pesans.jadwal_tgl')
                ->orderBy('jadwal_tgl', 'desc')
                ->first();

            $start = $st->jadwal_tgl;
            $end = $en->jadwal_tgl;
        } elseif ($validatorname->fails()) {

            $start = $request->Start;
            $end = $request->End;

            $data = pesan::select('pesans.id', 'pesans.no_order', 'pesans.jadwal_tgl', 'users.username', 'films.nama AS film', 'jadwals.start', 'teaters.nama', 'pesans.jml_kursi', 'transaksis.total')
                ->join('users', 'users.id', '=', 'pesans.id_user')
                ->join('films', 'films.id', '=', 'pesans.id_film')
                ->join('jadwals', 'jadwals.id', '=', 'pesans.id_jadwal')
                ->join('teaters', 'teaters.id', '=', 'pesans.id_teater')
                ->join('transaksis', 'transaksis.no_order', '=', 'pesans.no_order')
                ->orderBy('pesans.created_at', 'asc')
                ->whereBetween('pesans.jadwal_tgl', [$start, $end]);
        } elseif ($validator->fails()) {

            $username = $request->username;

            $data = pesan::select('pesans.id', 'pesans.no_order', 'pesans.jadwal_tgl', 'users.username', 'films.nama AS film', 'jadwals.start', 'teaters.nama', 'pesans.jml_kursi', 'transaksis.total')
                ->join('users', 'users.id', '=', 'pesans.id_user')
                ->join('films', 'films.id', '=', 'pesans.id_film')
                ->join('jadwals', 'jadwals.id', '=', 'pesans.id_jadwal')
                ->join('teaters', 'teaters.id', '=', 'pesans.id_teater')
                ->join('transaksis', 'transaksis.no_order', '=', 'pesans.no_order')
                ->orderBy('pesans.created_at', 'asc')
                ->where('users.username', '=', $username);

            $st = pesan::select('pesans.jadwal_tgl', 'users.username')
                ->orderBy('jadwal_tgl', 'asc')
                ->join('users', 'users.id', '=', 'pesans.id_user')
                ->where('users.username', '=', $username)
                ->first();

            $en = pesan::select('pesans.jadwal_tgl', 'users.username')
                ->orderBy('jadwal_tgl', 'desc')
                ->join('users', 'users.id', '=', 'pesans.id_user')
                ->where('users.username', '=', $username)
                ->first();

            $start = $st->jadwal_tgl;
            $end = $en->jadwal_tgl;
        } else {

            $username = $request->username;
            $start = $request->Start;
            $end = $request->End;

            $data = pesan::select('pesans.id', 'pesans.no_order', 'pesans.jadwal_tgl', 'users.username', 'films.nama AS film', 'jadwals.start', 'teaters.nama', 'pesans.jml_kursi', 'transaksis.total')
                ->join('users', 'users.id', '=', 'pesans.id_user')
                ->join('films', 'films.id', '=', 'pesans.id_film')
                ->join('jadwals', 'jadwals.id', '=', 'pesans.id_jadwal')
                ->join('teaters', 'teaters.id', '=', 'pesans.id_teater')
                ->join('transaksis', 'transaksis.no_order', '=', 'pesans.no_order')
                ->orderBy('pesans.created_at', 'asc')
                ->where('users.username', '=', $username)
                ->whereBetween('pesans.jadwal_tgl', [$start, $end]);
        }

        return view('admin.transaksi.laporan', [
            'data' => $data->get(),
            'start' => $start,
            'end' => $end
        ]);
    }
}
