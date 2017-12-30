<?php

namespace Tests\Feature;

use App\Concert;
use App\Billing\FakePaymentGateway;
use App\Billing\PaymentGateway;
use Tests\TestCase;
use Laravel\Dusk\Chrome;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PurchaseTicketsTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function customer_can_purchase_concert_tickets()
    { 

        $paymentGateway = new FakePaymentGateway;
        $this->app->instance(PaymentGateway::class, $paymentGateway);
        // Arrange
        // Create a concert
        $concert = factory(Concert::class)->create([
            'ticket_price' => 3250,
        ]);

        // Act
        // Purchase concert ticket
        $response = $this->json('POST', "/concerts/{$concert->id}/orders", [
            'email' => 'john@example.com',
            'ticket_quantity' => 3,
            'payment_token' => $paymentGateway->getValidTestToken(),
        ]);

        // Assert
        $response
            ->assertStatus(201);
            
        // Make suer the customer was charged the correct amount
        $this->assertEquals(9750, $paymentGateway->totalCharges());

        // Making sure that an order exists for this customer
        $order = $concert->orders()->where('email', 'john@example.com')->first();
        
        $this->assertNotNull($order);

        // $this->assertTrue($concert->orders->contains(function($order){
        //     return $order->email == 'john@example.com';
        // }));


        $this->assertEquals(3, $order->tickets->count());

    }
}