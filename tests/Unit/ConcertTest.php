<?php

namespace Tests\Unit;

use App\Concert;
use Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConcertTest extends TestCase
{

    public function test_can_get_formatted_date()
    {
        
        // Arrange
        // Create a concert with a known date
        $concert = factory(Concert::class)->make([
            'date' => Carbon::parse('2016-12-01 8:00pm'),
        ]);

        // Act
        // Retrieve the formatted date
        $date = $concert->formatted_date;
        
        // Assert
        // Verify the date is formatted as expected
        $this->assertEquals('December 1, 2016', $date);
    }

    public function test_can_get_formatted_start_time()
    {
        $concert = factory(Concert::class)->make([
            'date' => Carbon::parse('2016-12-01 17:00:00'),
        ]);

        $this->assertEquals('5:00pm', $concert->formatted_start_time);
    }

    public function test_can_get_ticekt_price_in_dollars()
    {
        $concert = factory(Concert::class)->make([
            'ticket_price' => 6750,
        ]);

        $this->assertEquals('67.50', $concert->ticket_price_in_dollars);
    }


    public function test_concerts_with_a_published_at_date_are_published()
    {
        
    }
}