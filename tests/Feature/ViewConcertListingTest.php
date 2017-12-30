<?php

namespace Tests\Feature;

use App\Concert;
use Carbon\Carbon;
use Tests\TestCase;
use Laravel\Dusk\Chrome;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ViewConcertListingTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function user_can_view_a_published_concert_listing()
    {
        // Arrange
        // Create a concert 
        $concert = factory(Concert::class)->states('published')->create([
            'title' => 'The Red Chord',
            'subtitle' => 'with Animosity and Lethargy',
            'date' => Carbon::parse('December 13, 2016 8:00pm'),
            'ticket_price' => 3250,
            'venue' => 'The Most Pit',
            'venue_address' => '123 Example Lane',
            'city' => 'Laraville',
            'post_code' => 'la12nr',
            'addtional_information' => 'For tickets, call (555) 555-5555.',
        ]);

        // Act
        // View the concert listing
        $response = $this->get('/concerts/'.$concert->id);

        // Assert 
        // Verify we could see concert details
        $response->assertStatus(200)
            ->assertSee('The Red Chord')
            ->assertSee('with Animosity and Lethargy')
            ->assertSee('December 13, 2016')
            ->assertSee('8:00pm')
            ->assertSee('32.50')
            ->assertSee('The Most Pit')
            ->assertSee('123 Example Lane')
            ->assertSee('Laraville, la12nr')
            ->assertSee('For tickets, call (555) 555-5555.');

    }

    /** @test */
    public function user_cannot_view_unpublished_conceret_listing(){

        $concert = factory(Concert::class)->states('unpublished')->create();

        $response = $this->get('/concerts/'.$concert->id);

        $response->assertStatus(404);
    }

    
}
