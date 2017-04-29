<?php
namespace Tests\Unit;

use App\Date;
use App\Option;
use App\Booking;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class OptionTest extends TestCase
{
    use DatabaseMigrations;


    /** @test */
    function creating_an_option_from_a_date()
    {
        // Arrange
        $date = factory(Date::class)->states('published')->create(
            ['price' => 500]
        );

        $this->assertEquals(0, $date->totalOptions());

        $option = Option::forDate($date, 'menno@test.com', 10, 5000);

        $this->assertEquals('menno@test.com', $option->email);
        $this->assertEquals(5000, $option->amount);
        $this->assertEquals(1, $date->totalOptions());
    }

    /** @test */
    function that_a_succesful_option_is_converting_to_an_array()
    {
        $date = factory(Date::class)->create(['price' => 5]);

        $option = Option::forDate($date, 'menno@test.com', 10, 5000);

        $result = $option->toArray();

        $this->assertEquals([
            'email' => 'menno@test.com',
            'pax' => 10,
            'amount' => 50
        ], $result);
    }

    /** @test */
    function option_is_deleted_when_an_option_is_cancelled()
    {
        $date = factory(Date::class)->create();
        $option = Option::forDate($date, 'menno@test.com', 10, 5000);
        $this->assertEquals(1, $date->totalOptions());
        $option->cancel($option->id);
        $this->assertEquals(0, $date->totalOptions());
        $this->assertNull(Option::find($option->id));
    }

    /** @test */
    public function if_a_option_is_already_booked()
    {
        $date = factory(Date::class)->create();
        $option = Option::forDate($date, 'menno@test.com', 10, 5000);
        $this->assertFalse($option->isBooked());
        Booking::forOption($option);
        $this->assertTrue($option->isBooked());
    }

}