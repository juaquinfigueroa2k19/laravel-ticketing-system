<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;

class DeviceController extends Controller
{
    public function addpost(Request $request)
    {
        try {
            // Validation
            $validatedData = $request->validate([
                'transaction_code' => 'required',
                'ticket_code' => 'required',
                'number_bet' => 'required',
                'ticket_type' => 'required',
                'draw_time' => 'required',
                'amount_bet' => 'required',
                'ticket_code_FK' => 'required',
            ]);
    
            // Create a transaction
            $transaction = Transaction::create([
                'transaction_code' => $validatedData['transaction_code'],
            ]);
    
            // Create a ticket related to the transaction
            $ticket = $transaction->tickets()->create([
                'ticket_code' => $validatedData['ticket_code'],
                'transaction_code_FK' => $validatedData['transaction_code'],
            ]);
    
            // If the input is not an array, convert it to an array for consistent processing
            $number_bet = is_array($validatedData['number_bet']) ? $validatedData['number_bet'] : [$validatedData['number_bet']];
            $ticket_type = is_array($validatedData['ticket_type']) ? $validatedData['ticket_type'] : [$validatedData['ticket_type']];
            $draw_time = is_array($validatedData['draw_time']) ? $validatedData['draw_time'] : [$validatedData['draw_time']];
            $amount_bet = is_array($validatedData['amount_bet']) ? $validatedData['amount_bet'] : [$validatedData['amount_bet']];
            $ticket_code_FK = is_array($validatedData['ticket_code_FK']) ? $validatedData['ticket_code_FK'] : [$validatedData['ticket_code_FK']];
    
            // Create bets
            foreach ($number_bet as $key => $betNumber) {
                $bet = $ticket->bets()->create([
                    'number_bet' => $betNumber,
                    'ticket_type' => $ticket_type[$key],
                    'draw_time' => $draw_time[$key],
                    'amount_bet' => $amount_bet[$key],
                    'ticket_code_FK' => $ticket_code_FK[$key],
                ]);
            }
    
            return [
                "transaction table" => "Transaction has been saved!",
                "ticket table" => "Ticket has been saved!",
                "bet table" => "Bets have been saved!",
            ];
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Error during model creation: ' . $e->getMessage());
    
            return ["result" => "Error during model creation. Please check the logs for more details."];
        }
    }
    

    public function fetchget(Request $request)
    {
        $transactions = Transaction::with('tickets.bets')->paginate(2);

        return View::make('pages.response')->with('transactions', $transactions);
    }
}
