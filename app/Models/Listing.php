<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
  use HasFactory;

  protected $fillable = [
    'title',
    'company',
    'location',
    'website',
    'email',
    'description',
    'tags',
    'logo',
  ];

  public function scopeFilter($query, array $filters)
  {
    if ($filters['tag'] ?? false) {
      $tag = '%' . request('tag') . '%';
      $query->where('tags', 'like', $tag);
    }

    if ($filters['search'] ?? false) {
      $searchTerm = '%' . request('search') . '%';

      $query->where(function ($query) use ($searchTerm) {
        $query
          ->where('title', 'like', $searchTerm)
          ->orWhere('description', 'like', $searchTerm)
          ->orWhere('tags', 'like', $searchTerm);
      });
    }
  }
}
