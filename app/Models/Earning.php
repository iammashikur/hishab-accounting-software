<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Earning extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['source', 'description', 'amount'];

    protected $searchableFields = ['*'];
}
