<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoanPayment extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['loan_id', 'amount'];

    protected $searchableFields = ['*'];

    protected $table = 'loan_payments';

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
