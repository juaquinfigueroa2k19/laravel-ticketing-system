<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tickets;

class Bets extends Model
{
    use HasFactory;
    protected $fillable = ['number_bet', 'ticket_type', 'draw_time', 'amount_bet', 'ticket_code_FK'];

    
    public function ticket()
    {
        return $this->belongsTo(Tickets::class);
    }
}
