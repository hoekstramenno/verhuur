<?php namespace Tests\Unit;

use App\Billing\FakePaymentGateway;
use App\Date;
use App\Reservation;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReservationTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function calculating_the_total_cost()
    {
        $date = new Date(['price' => 520]);
        $pax = 10;

        $reservation = new Reservation($date, $pax, 'menno@test.com');
        $this->assertEquals(5200, $reservation->totalCosts());
    }

    /** @test */
    function retrieving_a_reservation()
    {
        $date = new Date(['price' => 520]);
        $pax = 10;

        $reservation = new Reservation($date, $pax, 'menno@test.com');

        $this->assertEquals($date, $reservation->date());
    }

    /** @test */
    function retrieving_a_reservation_email()
    {
        $date = new Date(['price' => 520]);
        $pax = 10;
        $email = 'menno@test.com';

        $reservation = new Reservation($date, $pax, $email);

        $this->assertEquals($email, $reservation->email());
    }

    /** @test */
    function complete_a_reservation()
    {
        $date = new Date(['id' => 1, 'price' => 520]);
        $pax = 10;
        $email = 'menno@test.com';

        $reservation = new Reservation($date, $pax, $email);
        $paymentGateway = new FakePaymentGateway();

        $option = $reservation->toOption($paymentGateway, $paymentGateway->getValidTestToken());

        $this->assertEquals($pax, $option->pax);
        $this->assertEquals($email, $option->email);
        $this->assertEquals(1, $option->date_id);
        $this->assertEquals(5200, $option->amount);
        //$this->assertEquals(5200, $paymentGateway->totalCharges());

    }
}