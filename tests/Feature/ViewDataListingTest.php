<?php

use App\Date;
use App\Option;
use App\Booking;
use Carbon\Carbon;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ViewDataListingTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function user_can_view_all_available_dates()
    {
        factory(Date::class)->states('published')->create([
            'date_from' => Carbon::parse('+1 week'),
            'date_to' => Carbon::parse('+1 week'),
            'price' => 520,
            'status' => Date::STATUS_AVAILABLE
        ]);

        $optionedDate = factory(Date::class)->states('published')->create([
            'date_from' => Carbon::parse('+1 week'),
            'date_to' => Carbon::parse('+1 week'),
            'price' => 520,
            'status' => Date::STATUS_AVAILABLE
        ]);

        factory(Option::class)->create(['date_id' => $optionedDate->id]);

        $bookedDate = factory(Date::class)->states('published')->create([
            'date_from' => Carbon::parse('+1 week'),
            'date_to' => Carbon::parse('+1 week'),
            'price' => 520,
            'status' => Date::STATUS_AVAILABLE
        ]);

        $option = factory(Option::class)->create(['date_id' => $bookedDate->id]);
        factory(Booking::class)->create(['date_id' => $bookedDate->id, 'option_id' => $option->id]);

        // View the data listing
        $response = $this->get('/dates');

        // Assert
        // See the data details
        $response->assertStatus(200);
        $response->assertSee('Beschikbaar');
        $response->assertSee('1 optie genomen');
        $response->assertSee('Geboekt');


    }

    /** @test **/
    function user_can_view_a_published_date()
    {
        $date = factory(Date::class)->states('published')->create([
            'date_from' => Carbon::parse('December 13, 2016 8:00 pm'),
            'date_to' => Carbon::parse('December 14, 2016 01:00 pm'),
            'price' => 520,
            'status' => Date::STATUS_AVAILABLE
        ]);

        // Act
        // View the data listing
        $response = $this->get('/dates/' . $date->id);

        // Assert
        // See the data details
        $response->assertStatus(200);
        $response->assertSee('December 13, 2016');
        $response->assertSee('8:00 pm');
        $response->assertSee('December 14, 2016');
        $response->assertSee('1:00 pm');
        $response->assertSee('5,20');
        $response->assertSee('Beschikbaar');
        $response->assertSee('Total options: 0');

    }

    /** @test **/
    function user_can_see_the_total_options_for_this_date()
    {
        $date = factory(Date::class)->states('published')->create([
            'date_from' => Carbon::parse('December 13, 2016 8:00 pm'),
            'date_to' => Carbon::parse('December 14, 2016 01:00 pm'),
            'price' => 520,
            'status' => Date::STATUS_AVAILABLE
        ]);

        factory(Option::class)->create(['date_id' => $date->id]);
        factory(Option::class)->create(['date_id' => $date->id]);
        factory(Option::class)->create(['date_id' => $date->id]);
        factory(Option::class)->create(['date_id' => $date->id]);
        factory(Option::class)->create(['date_id' => $date->id]);

        // Act
        // View the data listing
        $response = $this->get('/dates/' . $date->id);

        // Assert
        // See the data details
        $response->assertStatus(200);
        $response->assertSee('Total options: 5');

    }

    /** @test **/
    function user_can_see_that_a_date_is_booked()
    {
        $date = factory(Date::class)->states('published')->create([
            'date_from' => Carbon::parse('December 13, 2016 8:00 pm'),
            'date_to' => Carbon::parse('December 14, 2016 01:00 pm')
        ]);

        factory(Option::class)->create(['date_id' => $date->id]);
        factory(Booking::class)->create(['date_id' => $date->id]);

        // Act
        // View the data listing
        $response = $this->get('/dates/' . $date->id);

        // Assert
        // See the data details
        $response->assertStatus(200);
        $response->assertSee('Geboekt');

    }

    /** @test **/
    function user_sees_a_cancelled_booking_again_as_available()
    {
        $date = factory(Date::class)->states('published')->create([
            'date_from' => Carbon::parse('December 13, 2016 8:00 pm'),
            'date_to' => Carbon::parse('December 14, 2016 01:00 pm')
        ]);

        factory(Option::class)->create(['date_id' => $date->id]);
        $booking = factory(Booking::class)->create(['date_id' => $date->id]);

        $response = $this->get('/dates/' . $date->id);
        $response->assertStatus(200);
        $response->assertSee('Geboekt');

        $booking->cancel();

        // View the data listing
        $response = $this->get('/dates/' . $date->id);
        $response->assertStatus(200);
        $response->assertSee('Beschikbaar');

    }

    /** @test **/
    function user_cannot_view_unpublished_dates()
    {
        // Arrange
        // Create a data
        $date = factory(Date::class)->states('unpublished')->create();

        // View the data listing
        $response = $this->get('/dates/' . $date->id);

        // See the data details
        $response->assertStatus(404);
    }
}
