<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Loan extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['source', 'description', 'amount'];

    protected $searchableFields = ['*'];

    public function loanPayments()
    {
        return $this->hasMany(LoanPayment::class);
    }
}
