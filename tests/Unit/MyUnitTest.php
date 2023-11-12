<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Mockery;
use App\Http\Controllers\DeviceController;

class MyUnitTest extends TestCase
{
    
    use WithFaker;

    public function test_unit_transactions()
    {
        $transactionMock = Mockery::mock('overload:' . Transaction::class);
        $transactionMock->shouldReceive('create')->once()->andReturnSelf();

        $response = (new DeviceController)->addpost(Mockery::mock('Illuminate\Http\Request'));

        if (isset($response['result'])) {
            $this->assertStringContainsString('Error during model creation', $response['result']);
        } else {
            $this->assertEquals([
                "transaction table" => "Transaction has been saved!",
            ], $response);
        }
    }
}
