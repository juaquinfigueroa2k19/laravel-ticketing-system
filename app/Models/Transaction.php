<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tickets;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = ['transaction_code'];

    public function tickets()
    {
        return $this->hasMany(Tickets::class, 'transaction_code_FK', 'transaction_code');
    }
}
