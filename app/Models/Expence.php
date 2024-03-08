<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expence extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['type', 'description', 'amount'];

    protected $searchableFields = ['*'];
}
