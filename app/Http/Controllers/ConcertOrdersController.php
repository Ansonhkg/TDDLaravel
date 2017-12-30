<?php

namespace App\Http\Controllers;

use App\Concert;
use Illuminate\Http\Request;
use App\Billing\PaymentGateway;

class ConcertOrdersController extends Controller
{

    private $paymentGateway;

    public function __construct(PaymentGateway $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    //
    public function store($concertId)
    {

        $concert = Concert::find($concertId);
        $ticketQuantity = request('ticket_quantity') ;
        $token = request('token');    
        $amount = $ticketQuantity * $concert->ticket_price;

        $this->paymentGateway->charge($amount, $token);

        return response()->json([], 201);
    }
}
