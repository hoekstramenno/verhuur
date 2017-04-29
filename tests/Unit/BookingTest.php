<?php

namespace Tests\Unit;

use App\Date;
use App\Option;
use App\Booking;
use App\Billing\FakePaymentGateway;
use App\Exceptions\NoBookingsLeftException;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookingTest extends TestCase
{
    use DatabaseMigrations;
    
    protected $option;

    private function createBooking()
    {
        $date = factory(Date::class)->create();
        $reservation = $date->createReservation($date, 10, 'menno@test.com');
        $paymentGateway = new FakePaymentGateway();
        $this->option = $reservation->toOption($paymentGateway, $paymentGateway->getValidTestToken());
        Booking::forOption($this->option);
    }

    /** @test */
    function creating_a_booking_from_an_option()
    {
        // Arrange
        $date = factory(Date::class)->states('published')->create(
            ['price' => 500]
        );

        $this->assertEquals(0, $date->totalOptions());

        $option = Option::forDate($date, 'menno@test.com', 10, 5000);
        $this->assertEquals(1, $date->totalOptions());

        $booking = Booking::forOption($option);

        $this->assertEquals($date->id, $booking->date_id);
        $this->assertEquals(0, $date->bookingsRemaining());
        $this->assertTrue($option->isBooked());
    }

    /** @test */
    public function booking_can_be_canceled()
    {
        $this->createBooking();

        $booking = $this->option->bookings()->first();
        $this->assertEquals($this->option->id, $booking->option_id);

        $booking->cancel();

        $this->assertNull($booking->fresh()->option_id);
        $this->assertFalse($this->option->isBooked());
    }

    /** @test */
    function can_add_booking_limit()
    {
        $date = factory(Date::class)->create();
        $date->addBookLimit(50);
        $this->assertEquals(50, $date->bookingsRemaining());
    }

    /** @test */
    function can_only_book_a_date_if_it_is_in_the_limit()
    {
        $date = factory(Date::class)->create();
        $date->addBookLimit(2);

        $option1 = Option::forDate($date, 'test1@test.com', 10, 5000);
        Booking::forOption($option1);

        $option2 = Option::forDate($date, 'test2@test.com', 10, 5000);
        Booking::forOption($option2);

        $this->assertEquals(0, $date->bookingsRemaining());

        try {
            Option::forDate($date, 'test3@test.com', 10, 5000);
        } catch (NoBookingsLeftException $e) {
            $this->assertNull($date->hasOptionsFor('test3@test.com'));
            $this->assertEquals(0, $date->bookingsRemaining());
            return;
        }
        $this->fail('There are more bookings than the limit');
    }


}
