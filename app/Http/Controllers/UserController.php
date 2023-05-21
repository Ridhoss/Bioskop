<?php

namespace App\Http\Controllers;

use App\Models\detailpesan;
use App\Models\film;
use App\Models\jadwal;
use App\Models\kursi;
use App\Models\metode;
use App\Models\news;
use App\Models\pesan;
use App\Models\teater;
use App\Models\transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use SebastianBergmann\Type\VoidType;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    // ke halaman login
    public function HalamanLog()
    {
        return view('users.loginuser', [
            'title' => 'Login | TIP'
        ]);
    }

    // login
    public function Login(Request $request)
    {
        $login = $request->validate([
            'username'=>'required',
            'password'=>'required'
        ]);

        if (Auth::guard('admin')->attempt($login)) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        if (Auth::guard('web')->attempt($login)) {
            $request->session()->regenerate();

            return redirect()->intended('/home');
        }

        return back()->with('gallog', 'login gagal');

    }

    // logout
    public function Logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->intended('/');
    }


    // ke halaman register
    public function HalamanReg()
    {
        return view('users.registeruser', [
            'title' => 'Register | TIP'
        ]);
    }

    // Register
    public function Register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'username'=>'required|min:5|unique:users|regex:/^[a-zA-z\s]*$/',
            'password'=>'required|min:5',
            'email'=>'required|unique:users|email:dns',
            'Name'=>'required',
            'Phone'=>'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect('/reguser')
                        ->withErrors($validator);
        }

        // hashing password
        $reg = Hash::make($request['password']);

        // post
        User::create([
            'username' => $request['username'],
            'name' => $request['Name'],
            'email' => $request['email'],
            'password' => $reg,
            'no_hp' => $request['Phone']
        ]);

        return redirect('/')->with('notif', 'Register Berhasil! Silahkan Login');
    }


    // ke halaman home
    public function Home()
    {
        $film = film::select('*')
        ->orderBy('created_at', 'desc')
        ->where('status', '=', '1');

        if (request('cari')) {
            $film->where('nama', 'like', '%' .request('cari'). '%');
        }

        return view('users.homeuser', [
            'title' => 'Home | TIP',
            'user' => Auth::user(),
            'film' => $film->get(),
            'count' => film::select('*')
                            ->where('status', '=', '1')
                            ->count(),
            'news' => news::select('*')
                            ->where('status', '=', '1')
                            ->orderBy('data_rilis', 'desc')
                            ->get(),
        ]);
    }

    // ke halaman profile
    public function Profile()
    {
        return view('users.profile', [
            'title' => 'Profile | TIP',
            'user' => Auth::user()
        ]);
    }

    // edit profile biodata
    public function EditProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'NewImage' => 'image|mimes:jpg,jpeg,png,svg,gif|max:2048',
            'username' => 'required|min:5',
            'nama' => 'required',
            'email' => 'required|email:dns',
            'no' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('/profile')
                        ->withErrors($validator);
        }

        $id = User::find($request->id);

        if ($request->hasFile('NewImage')) {

            // upload gambar baru
            $image = $request->file('NewImage');
            $image->storeAs('public/users', $image->hashName());

            // hapus gambar lama
            Storage::delete('public/users/'. $request->gambarlama);

            // update profile
            $id->update([
                'username' => $request->username,
                'name' => $request->nama,
                'email' => $request->email,
                'no_hp' => $request->no,
                'gambar' => $image->hashName()
            ]);

        }else {
            $id->update([
                'username' => $request->username,
                'name' => $request->nama,
                'email' => $request->email,
                'no_hp' => $request->no
            ]);
            
        }

        return redirect('/profile')->with('berhasilbio', 'data berhasil di ubah');

    }

    public function EditPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|current_password',
            'new_password' => 'required|confirmed'
        ]);

        if ($validator->fails()) {
            return redirect('/profile')
                        ->withErrors($validator);
        }

        $user = User::find($request->id);

        $user -> password = Hash::make($request->new_password);

        $user->save();

        $request->session()->regenerate();

        return back()->with('berhasilpass', 'password di ubah');

    }


    // Ke halaman desc
    public function Desc(film $id)
    {
        return view('users.desc', [
            'title' => 'Deskripsi | TIP',
            'user' => Auth::user(),
            'film' => $id,
            'teater' => teater::all()
        ]);
    }


    // Ke halaman book
    public function Book(Request $request)
    {
        $teater = $request->teater;
        $film = $request->film;
        $tanggal = $request->tanggal;
        $t = teater::find($teater);
        $today = Carbon::now()->format('H:i');

        foreach ($t as $teater) {
            $n = $t->nama;
        }

        return view('users.book', [
            'title' => 'Book | TIP',
            'user' => Auth::user(),
            'film' => film::find($film),
            'tanggal' => $tanggal,
            'teater' => $t,
            'today' => $today,
            'jadwal' => jadwal::select('jadwals.*')
                                ->where('jadwals.teater', '=', $n)
                                ->get(),
            'pesan' => detailpesan::select('*')
                                ->join('pesans','detailpesans.no_order','=','pesans.no_order')
                                ->where('pesans.id_film','=',$film)
                                ->where('pesans.id_teater','=',$teater)
                                ->get()
        ]);
    }

    // ke halaman pilih kursi
    public function GoSeat(Request $request)
    {

        $teater = $request->teater;
        $film = $request->film;
        $jadwal = $request->jadwal;
        $tanggal = $request->tanggal;

        $t = teater::find($teater);

        // $pes = detailpesan::select('*')
        //                 ->join('pesans','detailpesans.no_order','=','pesans.no_order')
        //                 ->where('pesans.jadwal_tgl','=',$tanggal)
        //                 ->where('pesans.id_film','=',$film)
        //                 ->where('pesans.id_teater','=',$teater)
        //                 ->where('pesans.id_jadwal','=',$jadwal)
        //                 ->get();


        return view('users.seat', [
            'title' => 'Book Seat | TIP',
            'user' => Auth::user(),
            'teater' => $t,
            'tanggal' => $tanggal,
            'film' => film::find($film),
            'jadwal' => jadwal::find($jadwal),
            'seat' => kursi::select('*')
                            ->where('teater', '=', $t->nama)
                            ->get(),
            'pesan' => detailpesan::select('*')
                        ->join('pesans','detailpesans.no_order','=','pesans.no_order')
                        ->where('pesans.jadwal_tgl','=',$tanggal)
                        ->where('pesans.id_film','=',$film)
                        ->where('pesans.id_teater','=',$teater)
                        ->where('pesans.id_jadwal','=',$jadwal)
                        ->get()
        ]);

    }


    // halaman detail
    public function Detail(Request $request)
    {
        
        $teater = $request->teater;
        $film = $request->film;
        $jadwal = $request->jadwal;
        $kursi = $request->kursi;
        $tanggal = $request->tanggal;

        $t = teater::find($teater);

        // hitung jumlah kursi
        
        $jumlah = count($kursi);
        
        // mengembalikan data kursi berdasarkan nomor
        
        $str = "";

        foreach ($kursi as $krs) {
            $str .= $krs . ", ";
        }
        
        $str = rtrim($str, ", ");

        // mengembalikan data kursi berdasarkan id

        foreach ($kursi as $k) {
            $krsn = kursi::select('*')
                        ->where('no_kursi' ,'=', $k)
                        ->where('teater', '=', $t->nama)
                        ->get();

            foreach ($krsn as $kp) {
                         $id[] = $kp->id;
                    }

        }

        return view('users.detail',[
            'title' => 'Detail Order | TIP',
            'user' => Auth::user(),
            'teater' => $t,
            'tanggal' => $tanggal,
            'film' => film::find($film),
            'jadwal' => jadwal::find($jadwal),
            'seat' => $str,
            'kursi' => $id,
            'jumlah' => $jumlah,
            'metode' => metode::select('*')
                                ->where('status', '=', '1')
                                ->get()
        ]);
    }


    // booking
    public function Booking(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user' => 'required',
            'film' => 'required',
            'teater' => 'required',
            'jadwal' => 'required',
            'tanggal' => 'required',
            'no_order' => 'required',
            'kursi' => 'required',
            'total' => 'required',
            'metode' => 'required',
            'phone' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect('/home')
                ->withErrors($validator);
        }

        $t = teater::find($request->teater);


        pesan::create([
            'no_order' => $request->no_order,
            'id_user' => $request->user,
            'id_film' => $request->film,
            'id_jadwal' => $request->jadwal,
            'id_teater' => $request->teater,
            'jadwal_tgl' => $request->tanggal,
            'jml_kursi' => count($request->kursi)
        ]);

        transaksi::create([
            'no_order' => $request->no_order,
            'tgl_trans' => date('Ymd'),
            'metode' => $request->metode,
            'total' => $request->total,
            'no_hp' => $request->phone,
        ]);

        foreach ($request->kursi as $kursi) {

            $customcode = $request->no_order.'K'.$kursi;
            
            detailpesan::create([
                'no_order' => $request->no_order,
                'idno_kursi' => $customcode,
                'id_kursi' => $kursi,
                'harga' => $t->harga,
                'status' => '1'
            ]);

        }

        return redirect()->intended('/ticket');

    }

    

    // ke halaman tiket


    public function Ticket()
    {
        $id = Auth::user();

        return view('users.ticket',[
            
            'title' => 'Your Ticket | TIP',
            'user' => $id,
            'tiket' => pesan::select('pesans.no_order','pesans.jadwal_tgl','films.nama AS film','films.foto', 'jadwals.start AS jadwal', 'teaters.nama AS teater', 'transaksis.tgl_trans', 'transaksis.total')
                    ->join('films','films.id','=','pesans.id_film')
                    ->join('jadwals','jadwals.id','=','pesans.id_jadwal')
                    ->join('teaters','teaters.id','=','pesans.id_teater')
                    ->join('transaksis','transaksis.no_order','=','pesans.no_order')
                    ->where('id_user','=',$id->id)
                    ->orderBy('pesans.created_at', 'desc')
                    ->get()
        ]);
    }

    public function DetailTicket(Request $request)
    {

        $id = Auth::user();

        $order = $request->no;

        $pesan = pesan::select('*')
                ->where('no_order','=',$order)
                ->get();

        return view('users.detailticket', [
            'title' => 'Your Ticket | TIP',
            'user' => $id,
            'no' => $order,
            'order' => pesan::select('films.nama AS namaFilm','films.foto','films.durasi','films.genre','teaters.nama AS teater','teaters.harga','jadwals.start AS jadwal','pesans.jadwal_tgl AS tgl_tayang','pesans.jml_kursi AS totaltiket','metodes.nama AS method','transaksis.tgl_trans','transaksis.total AS totalCost')
                            ->where('pesans.no_order','=',$order)
                            ->join('transaksis','transaksis.no_order','=','pesans.no_order')
                            ->join('films','films.id','=','pesans.id_film')
                            ->join('teaters','teaters.id','=','pesans.id_teater')
                            ->join('jadwals','jadwals.id','=','pesans.id_jadwal')
                            ->join('metodes','metodes.id','=','transaksis.metode')
                            ->get(),

            'tiket' => detailpesan::select('detailpesans.*','kursis.no_kursi')
                                    ->where('no_order','=',$order)
                                    ->join('kursis','detailpesans.id_kursi','=','kursis.id')
                                    ->get()
        
        ]);
    }




}
