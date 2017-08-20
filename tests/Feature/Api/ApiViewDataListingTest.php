<?php

use App\Date;
use App\Option;
use App\Booking;
use Carbon\Carbon;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiViewDataListingTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var string
     */
    protected $date_from = '';

    /**
     * @var string
     */
    protected $date_to = '';

    function setUp() {
        parent::setUp();
        $this->date_from = Carbon::now();
        $this->date_to = Carbon::parse('+1 day');
        $this->passportLogin();
    }


    /** @test */
    function user_can_view_all_available_dates()
    {
        factory(Date::class, 3)->states('published')->create([
            'date_from' => Carbon::parse('+1 week'),
            'date_to' => Carbon::parse('+1 week + 1 day'),
            'price' => 520,
            'status' => Date::STATUS_AVAILABLE
        ]);

        // View the data listing
        $response = $this->get('/api/dates', ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        // Assert
        // See the data details
        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'start' => Carbon::parse('+1 week')->toDateTimeString(),
                'end' => Carbon::parse('+1 week +1 day')->toDateTimeString(),
                'datesCount' => 3
            ]);
    }

    /** @test **/
    function user_can_view_a_published_date()
    {
        $date = factory(Date::class)->states('published')->create([
            'date_from' => $this->date_from,
            'date_to' => $this->date_to
        ]);

        $response = $this->json('get', 'api/dates/' . $date->id, ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'start' =>  $this->date_from->toDateTimeString(),
                'end' => $this->date_to->toDateTimeString()
            ]);
    }

    /** @test **/
    function user_can_not_see_old_dates()
    {
        $date = factory(Date::class)->states('published')->create([
            'date_from' => Carbon::parse('-1 month'),
            'date_to' => Carbon::parse('-1 month +1 day'),
            'price' => 520,
            'admin_id' => 1,
            'status' => Date::STATUS_AVAILABLE
        ]);

        $response = $this->json('get', 'api/dates/' . $date->id, ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(204);
    }

    /** @test **/
    function user_can_see_the_total_options_for_this_date()
    {
        $date = factory(Date::class)->states('published')->create([
            'date_from' =>  $this->date_from,
            'date_to' => $this->date_to,
            'price' => 520,
            'status' => Date::STATUS_AVAILABLE
        ]);

        factory(Option::class, 5)->create(['date_id' => $date->id]);

        // Act
        // View the data listing
        $response = $this->json('get', 'api/dates/' . $date->id, ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        // Assert
        // See the data details
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'start' =>  $this->date_from->toDateTimeString(),
            'end' => $this->date_to->toDateTimeString(),
            'total_options' => 5
        ]);

    }

    /** @test **/
    function user_can_see_that_a_date_is_booked()
    {
        $date = factory(Date::class)->states('published')->create([
            'date_from' =>  $this->date_from,
            'date_to' => $this->date_to,
        ]);

        factory(Option::class, 1)->create(['date_id' => $date->id]);
        factory(Booking::class)->create(['date_id' => $date->id]);

        // Act
        $response = $this->json('get', 'api/dates/' . $date->id, ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        // Assert
        // See the data details
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'start' =>  $this->date_from->toDateTimeString(),
            'end' => $this->date_to->toDateTimeString(),
            'status' => ['code' => '2', 'label' => 'Geboekt']
        ]);

    }

    /** @test **/
    function user_sees_a_cancelled_booking_again_as_available()
    {
        $date = factory(Date::class)->states('published')->create([
            'date_from' =>  $this->date_from->toDateTimeString(),
            'date_to' => $this->date_to->toDateTimeString(),
        ]);

        factory(Option::class)->create(['date_id' => $date->id]);
        $booking = factory(Booking::class)->create(['date_id' => $date->id]);

        $response = $this->json('get', 'api/dates/' . $date->id, ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'start' =>  $this->date_from->toDateTimeString(),
            'end' => $this->date_to->toDateTimeString(),
            'status' => ['code' => '2', 'label' => 'Geboekt']
        ]);

        $booking->cancel();

        // View the data listing
        $response = $this->json('get', 'api/dates/' . $date->id, ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'start' =>  $this->date_from->toDateTimeString(),
            'end' => $this->date_to->toDateTimeString(),
            'status' => ['code' => '1', 'label' => 'Beschikbaar']
        ]);
    }

    /** @test **/
    function user_cannot_view_unpublished_dates()
    {
        // Arrange
        // Create a data
        $date = factory(Date::class)->states('unpublished')->create();

        // View the data listing
        $response = $this->get('/dates/' . $date->id, ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        // See the data details
        $response->assertStatus(404);
    }
}
