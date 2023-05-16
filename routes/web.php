<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Models\admin;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// USER

// Route::get('/', function () {
//     return view('welcome');
// });

// login
Route::get('/', [UserController::class, 'HalamanLog'])->middleware('guest')->name('login');
Route::post('/loginuser', [UserController::class, 'Login']);

// logout
Route::post('/logout', [UserController::class, 'Logout']);

// register
Route::get('/reguser', [UserController::class, 'HalamanReg'])->middleware('guest');
// aksi register
Route::post('/reguser', [UserController::class, 'Register']);

// ke home
Route::get('/home', [UserController::class, 'Home'])->middleware('auth:web');

// ke profile
Route::get('/profile', [UserController::class, 'Profile'])->middleware('auth:web');
// edit profile
Route::post('/editprofile', [UserController::class, 'EditProfile']);
// edit password
Route::post('/editpassword', [UserController::class, 'EditPassword']);

// ke halaman deskripsi
Route::get('/desc/{id}', [UserController::class, 'Desc'])->middleware('auth:web');

// ke halaman book
Route::post('/book', [UserController::class, 'Book'])->middleware('auth:web');

// ke halaman pilih bangku
Route::post('/seat', [UserController::class, 'GoSeat'])->middleware('auth:web');

// ke halaman detail pesan & pembayaran
Route::post('/detail', [UserController::class, 'Detail'])->middleware('auth:web');

// booking
Route::post('/go', [UserController::class, 'Booking']);

// Ticket
Route::get('/ticket', [UserController::class, 'Ticket'])->middleware('auth:web');

// Ticket
Route::post('/detail-ticket', [UserController::class, 'DetailTicket'])->middleware('auth:web');







// ADMIN

// ke halaman login
// Route::get('/admin', [AdminController::class, 'HalamanLog'])->middleware('guest');
// Login Admin
// Route::post('/loginadmin', [AdminController::class, 'Login']);
// logout
// Route::post('/logoutadmin', [AdminController::class, 'Logout']);

// ke dashboard
Route::get('/dashboard', [AdminController::class, 'Dashboard'])->middleware('auth:admin');

// Data Film

// ke data film
Route::get('/film', [AdminController::class, 'Film'])->middleware('auth:admin');
// tambah film
Route::post('/addfilm', [AdminController::class, 'AddFilm']);
// ganti status film
Route::post('/statusfilm', [AdminController::class, 'StatusFilm']);
// Edit data film
Route::post('/editfilm', [AdminController::class, 'EditFilm']);
// Edit data film
Route::post('/hapusfilm', [AdminController::class, 'HapusFilm']);


// Data Genre

// ke halaman data genre
Route::get('/genre', [AdminController::class, 'Genre'])->middleware('auth:admin');
// tambah genre
Route::post('/addgenre', [AdminController::class, 'AddGenre']);
// edit genre
Route::post('/editgenre', [AdminController::class, 'EditGenre']);
// hapus genre
Route::post('/hapusgenre', [AdminController::class, 'HapusGenre']);


// Data News

// ke halaman data news
Route::get('/news', [AdminController::class, 'News'])->middleware('auth:admin');
// tambah data news
Route::post('/addnews', [AdminController::class, 'AddNews']);
// ganti status news
Route::post('/statusnews', [AdminController::class, 'StatusNews']);
// edit data news
Route::post('/editnews', [AdminController::class, 'EditNews']);
// hapus data news
Route::post('/hapusnews', [AdminController::class, 'HapusNews']);


// Data Teater

// ke halaman data teater
Route::get('/teater', [AdminController::class, 'Teater'])->middleware('auth:admin');
// tambah data teater
Route::post('/addteater', [AdminController::class, 'AddTeater']);
// ganti status teater
Route::post('/statusteater', [AdminController::class, 'StatusTeater']);
// edit teater
Route::post('/editteater', [AdminController::class, 'EditTeater']);
// delete teater
Route::post('/hapusteater', [AdminController::class, 'HapusTeater']);


// Data Jadwal

// ke halaman data jadwal
Route::get('/schedule', [AdminController::class, 'Jadwal'])->middleware('auth:admin');
// tambah data teater
Route::post('/addschedule', [AdminController::class, 'AddSchedule']);
// ganti status teater
Route::post('/statusschedule', [AdminController::class, 'StatusSchedule']);
// edit teater
Route::post('/editschedule', [AdminController::class, 'EditSchedule']);
// delete teater
Route::post('/hapusschedule', [AdminController::class, 'HapusSchedule']);



// Data Admin

// ke halaman data admin
Route::get('/admindata', [AdminController::class, 'AdminData'])->middleware('auth:admin');
// tambah data teater
Route::post('/addadmin', [AdminController::class, 'AddAdmin']);
// edit teater
Route::post('/editadmin', [AdminController::class, 'EditAdmin']);
// delete teater
Route::post('/hapusadmin', [AdminController::class, 'HapusAdmin']);


// Data User

// Ke halaman data user
Route::get('/userdata', [AdminController::class, 'UserData'])->middleware('auth:admin');
// tambah data teater
Route::post('/adduser', [AdminController::class, 'AddUser']);
// edit teater
Route::post('/edituser', [AdminController::class, 'EditUser']);
// delete teater
Route::post('/hapususer', [AdminController::class, 'HapusUser']);



// Data Kursi

// ke halaman data kursi
Route::get('/seatdata', [AdminController::class, 'SeatData'])->middleware('auth:admin');
// tambah data teater
Route::post('/addSeat', [AdminController::class, 'AddSeat']);
// ganti status teater
Route::post('/statusSeat', [AdminController::class, 'StatusSeat']);
// edit teater
Route::post('/editSeat', [AdminController::class, 'EditSeat']);
// delete teater
Route::post('/hapusSeat', [AdminController::class, 'HapusSeat']);


// Data Metode

// ke halaman data kursi
Route::get('/Metode', [AdminController::class, 'MetodeData'])->middleware('auth:admin');
// tambah data teater
Route::post('/addMetode', [AdminController::class, 'AddMetode']);
// ganti status teater
Route::post('/statusMetode', [AdminController::class, 'StatusMetode']);
// edit teater
Route::post('/editMetode', [AdminController::class, 'EditMetode']);
// delete teater
Route::post('/hapusMetode', [AdminController::class, 'HapusMetode']);






// TRANSAKSI

// Data Pesan

// ke halaman data pesan
Route::get('/order', [AdminController::class, 'Order'])->middleware('auth:admin');
// delete teater
Route::post('/hapuspesan', [AdminController::class, 'HapusPesan']);

// Data Detail Pesan

// ke halaman data pesan
Route::get('/detail-order', [AdminController::class, 'DetailOrder'])->middleware('auth:admin');
// delete teater
Route::post('/hapusdetail', [AdminController::class, 'HapusDetail']);
// status detail
Route::post('/statusDetail', [AdminController::class, 'StatusDetail']);
// status detail
Route::post('/statusDetailDash', [AdminController::class, 'StatusDetailDash']);

// Data Transaksi

// ke halaman data pesan
Route::get('/transcation', [AdminController::class, 'Transaction'])->middleware('auth:admin');
// delete teater
Route::post('/hapustransaksi', [AdminController::class, 'HapusTransaksi']);