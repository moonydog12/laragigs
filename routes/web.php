<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Listing;

// All listings
Route::get('/', function () {
  return view('listings', [
    'heading' => 'Latest Listings',
    'listings' => Listing::all(),
  ]);
});

Route::get('/hello', function () {
  return response('<h1>Hello World</h1>')
    ->header('Content-Type', 'text/plain')
    ->header('foo', 'bar');
});

// Single listing
Route::get('/listings/{id}', function ($id) {
  return view('listing', [
    'listing' => Listing::find($id),
  ]);
});
