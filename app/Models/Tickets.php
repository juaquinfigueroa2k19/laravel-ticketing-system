<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bets;
use App\Models\Transaction;

class Tickets extends Model
{
    use HasFactory;
    protected $fillable = ['ticket_code', 'transaction_code_FK'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_code_FK', 'transaction_code');
    }

    public function bets()
    {
        return $this->hasMany(Bets::class, 'ticket_code_FK', 'ticket_code');
    }
}
