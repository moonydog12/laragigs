<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;
use Illuminate\Contracts\Session\Session;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
  // Show all listings
  public function index()
  {
    return view('listings.index', [
      'listings' => Listing::latest()
        ->filter(request(['tag', 'search']))
        ->paginate(6),
    ]);
  }

  //   Single listing
  //   使用 laravel model binding 語法
  public function show(Listing $listing)
  {
    return view('listings.show', [
      'listing' => $listing,
    ]);
  }

  // Show create form
  public function create()
  {
    return view('listings.create');
  }

  // Store listing data
  public function store(Request $request)
  {
    // 表單驗證(laravel特殊用法?)
    $formFields = $request->validate([
      'title' => 'required',
      'company' => ['required', Rule::unique('listings', 'company')],
      'location' => 'required',
      'website' => 'required',
      'email' => ['required', 'email'],
      'tags' => 'required',
      'description' => 'required',
    ]);

    if ($request->hasFile('logo')) {
      $formFields['logo'] = $request
        ->file('logo')->store('logos', 'public');
    }


    Listing::create($formFields);

    return redirect('/')->with('message', 'Listing created successfully!');
  }

  // show edit form
  public function edit(Listing $listing)
  {
    return view('listings.edit', ['listing' => $listing]);
  }

  // Update listing
  public function update(Request $request, Listing $listing)
  {
    $formFields = $request->validate([
      'title' => 'required',
      'company' => ['required'],
      'location' => 'required',
      'website' => 'required',
      'email' => ['required', 'email'],
      'tags' => 'required',
      'description' => 'required',
    ]);

    if ($request->hasFile('logo')) {
      $formFields['logo'] = $request
        ->file('logo')->store('logos', 'public');
    }

    $listing->update($formFields);

    return back()->with('message', 'Listing updated successfully!');
  }
}
