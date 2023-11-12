<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Factories\TransactionFactory;

class MyFeatureTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function test_it_add_the_transactions()
    {
        $transData = [
            'transaction_code' => '90908',
            'ticket_code' => '34534',
            'number_bet' => '234',
            'ticket_type' => 'type_A',
            'draw_time' => 'draw_B',
            'amount_bet' => '10',
            'ticket_code_FK' => '34534',
        ];

        $response = $this->post('/api/add', $transData);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            "transaction table" => "Transaction has been saved!"
        ]);
    }

    public function test_it_fetch_transactions()
    {
        TransactionFactory::new()->count(5)->create();

        $response = $this->get('/api/fetch');

        $response->assertStatus(200);
    }
}
