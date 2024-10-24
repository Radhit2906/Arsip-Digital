<?php

use App\Models\Post;
use App\Models\User;
use App\Models\kategoris;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SubKategoriController;


Route::get('/', function () {
    return view('home',['title' => 'Input Data']);
});



// Route::get('/about', function () {
//     return view('about',['title'=>' About']);
// });


// Route::get('/posts', function () {
//     return view('posts',['title' => 'Arsip','posts'=>Post::all()]);
// });

// Route::get('/posts/{post:slug}', function (Post $post) {
//      return view('post',['title'=>'Single Post','post'=>$post]);
// });

// Route::get('/contact', function () {
//     return view('contact',['title'=> 'Contact']);
// });

// Route::get('/authors/{user}', function (User $user) {
//     return view('posts',['title'=>' Articles by '. $user->name ,'posts'=>$user->posts]);
// });

// routes/web.php

Route::post('/posts', [InvoiceController::class, 'store'])->name('posts.store');


Route::get('/posts', [InvoiceController::class, 'index'])->name('posts.index');

Route::post('/posts/store', [InvoiceController::class, 'store'])->name('posts.store');

Route::resource('posts', InvoiceController::class);

Route::get('/get-sellers', [InvoiceController::class, 'getSellers'])->name('get.sellers');
Route::get('/get-payers', [InvoiceController::class, 'getPayers'])->name('get.payers');

Route::get('/get-subcategories/{id}', [InvoiceController::class, 'getSubcategories']);

// routes/web.php

Route::get('/subkategoris/byKategori/{kategori_id}', [SubKategoriController::class, 'getByKategori']);

Route::get('/posts/{kategori_id?}', [InvoiceController::class, 'index'])->name('posts.index');

Route::get('/', function () {
    $kategoris = kategoris::all();
    return view('home',['title' => 'Input Data'], compact('kategoris'));
});


Route::get('/kategori', [KategoriController::class, 'create'])->name('kategori.create');
Route::post('/kategori', [KategoriController::class, 'storeKategori'])->name('kategori.store');
Route::post('/subkategori', [KategoriController::class, 'storeSubKategori'])->name('subkategori.store');


Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
Route::delete('/subkategori/{id}', [SubKategoriController::class, 'destroy'])->name('subkategori.destroy');


//route daftar kategori
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');

Route::get('/get-subkategoris', [KategoriController::class, 'getSubKategoris'])->name('get.subkategoris');


Route::resource('kategori', KategoriController::class);

// Route::post('/store-kategori', [KategoriController::class, 'store'])->name('storeKategori');
// Route::get('/get-subkategori/{id}', [KategoriController::class, 'getSubkategori']);


Route::get('/get-subkategoris', [InvoiceController::class, 'getSubKategoris'])->name('get.subkategoris');
Route::get('/get-subcategories/{id}', [InvoiceController::class, 'getSubcategories'])->name('get.subcategories');


Route::get('/get-subkategoris/{kategori_id}', [InvoiceController::class, 'getSubKategoris']);
