 <?php

// use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
  //  return view('welcome');
//});

//Route::get('/halo-dunia', function() {
   // return '<h1>Halo dunia</h1>';
//});

//Route::get('/halo/{nama?}', function($nama = 'Tanpa Nama') {
  //  return '<h1>Halo ' . $nama. '</h1>';
//});

//Route::get('/halo_dunia', function() {
  //  return view('halo_dunia'); -->
    // memanggil resources/views/halo_dunia.blade.php
// });


use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/education', function () {
    return view('education');
})->name('education');

Route::get('/projects', function () {
    return view('projects');
})->name('projects');


