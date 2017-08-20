<?php

namespace Tests\Unit;

use App\Date;
use App\Http\Requests\MultiStoreDate;
use App\Option;
use App\Booking;
use App\Exceptions\NoBookingsLeftException;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DateTest extends TestCase
{
    use DatabaseMigrations;


    /** @test */
    public function test_get_formatted_dates()
    {
        // Create option with a known from date
        $option = factory(Date::class)->make([
            'date_from' => Carbon::parse('2016-12-01 8:00pm'),
            'date_to' => Carbon::parse('2016-12-02 12:00pm')
        ]);

        $this->assertEquals('December 1, 2016', $option->formatted_from_date);
        $this->assertEquals('December 2, 2016', $option->formatted_to_date);
    }

    /** @test */
    public function can_get_formatted_times()
    {
        $option = factory(Date::class)->make([
            'date_from' => Carbon::parse('2016-12-01 8:00pm'),
            'date_to' => Carbon::parse('2016-12-02 12:00pm')
        ]);

        $this->assertEquals('8:00 pm', $option->formatted_start_time);
        $this->assertEquals('12:00 pm', $option->formatted_end_time);

    }

    /** @test */
    public function can_get_price_in_euros()
    {
        $option = factory(Date::class)->make([
            'price' => 923
        ]);

        $this->assertEquals('9,23', $option->formatted_price);
    }

    /** @test */
    public function options_with_a_published_at_date_are_published()
    {
        $publishedDateA = factory(Date::class)->create([
            'published_at' => Carbon::parse('-1 week')
        ]);

        $publishedDateB = factory(Date::class)->create([
            'published_at' => Carbon::parse('-1 week')
        ]);

        $unpublishedDate = factory(Date::class)->create([
            'published_at' => null
        ]);

        $publishedDates = Date::published()->get();

        $this->assertTrue($publishedDates->contains($publishedDateA));
        $this->assertTrue($publishedDates->contains($publishedDateB));
        $this->assertFalse($publishedDates->contains($unpublishedDate));
    }

    /** @test */
    public function cannot_see_dates_from_the_past()
    {
        $publishedDateA = factory(Date::class)->create([
            'date_from' => Carbon::parse('-1 week')
        ]);

        $publishedDateB = factory(Date::class)->create([
            'date_from' => Carbon::parse('today')
        ]);

        $publishedDateC = factory(Date::class)->create([
            'date_from' => Carbon::parse('+1 week')
        ]);

        $publishedDates = Date::future()->get();

        $this->assertFalse($publishedDates->contains($publishedDateA));
        $this->assertTrue($publishedDates->contains($publishedDateB));
        $this->assertTrue($publishedDates->contains($publishedDateC));
    }

    /**
     * @test
     */
    public function can_create_new_dates_from_a_range()
    {
        $first = [
            'start' => Carbon::now()->toDateTimeString(),
            'end' => Carbon::parse('+1 week')->toDateTimeString()
        ];

        $second = [
            'start' => Carbon::parse('+1 week')->toDateTimeString(),
            'end' => Carbon::parse('+2 month')->toDateTimeString()
        ];

        $dates = [$first, $second];

        $request = new MultiStoreDate([
            'price' => 520,
            'published_at' => Carbon::now()->toDateTimeString(),
            'admin_id' => 1
        ]);

        $publishedDates = Date::createRange($request, $dates);

        $publishedDates = $publishedDates->toArray();

        $this->assertEquals(count($publishedDates), 2);

        $this->assertEquals($publishedDates[0]['date_from'], $first['start']);
        $this->assertEquals($publishedDates[0]['date_to'], $first['end']);

        $this->assertEquals($publishedDates[1]['date_from'], $second['start']);
        $this->assertEquals($publishedDates[1]['date_to'], $second['end']);
    }

    /** @test */
//    function can_option_an_date()
//    {
//        $date = factory(Date::class)->create();
//        $option = Option::forDate($date, 'menno@test.com', 10, 5000);
//        $this->assertEquals('menno@test.com', $option->email);
//
//    }

    /** @test */
//    function can_create_a_reservation_for_a_option()
//    {
//        $date = factory(Date::class)->create();
//
//        $reservation = $date->createReservation($date, 10, 'menno@test.com');
//
//        $this->assertEquals($date, $reservation->date());
//        $this->assertEquals('menno@test.com', $reservation->email());
//    }

    /** @test */
    public function can_get_current_status_label()
    {
        $date = factory(Date::class)->create();
        $this->assertEquals($date->getStatusLabel(), 'Beschikbaar');
    }

    /**
     * @test
     */
    public function can_read_human_readable_text_from_the_status_label()
    {
        $date = new Date();

        $this->assertEquals($date->getLabel(1), 'Beschikbaar');
        $this->assertEquals($date->getLabel(2), 'Geboekt');
        $this->assertEquals($date->getLabel(3), 'Niet beschikbaar');


    }

    /**
     * @test
     */
    public function only_get_the_dates_that_are_available()
    {
        $dates = factory(Date::class, 3)->create();
        factory(Date::class)->create([
            'status' => 2
        ]);

        $allAvailableDates = Date::where('status', 1)->get();

        $allAvailableDatesWithScope = Date::available()->get();

        $this->assertEquals($allAvailableDates, $allAvailableDatesWithScope);
    }

}
