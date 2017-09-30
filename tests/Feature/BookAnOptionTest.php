<?php

use App\Date;
use App\Option;
use App\Billing\FakePaymentGateway;
use App\Billing\PaymentGateway;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BookAnOptionTest extends TestCase
{
    use DatabaseMigrations;

    protected $payentGateway;

    protected function setUp()
    {
        parent::setUp();
        $this->paymentGateway = new FakePaymentGateway;
        $this->app->instance(PaymentGateway::class, $this->paymentGateway);
    }

    private function bookAnOptionPost($option, $params)
    {
        return $this->json('POST', "/api/options/{$option->id}/bookings", $params);
    }

    private function assertValidationError($response, $field)
    {
        $response->assertStatus(422);
        $this->assertArrayHasKey($field, $response->decodeResponseJson());
    }

    /** @test */
    function admin_can_book_an_option()
    {
        $this->passportLogin();

        // Arrange
        $date = factory(Date::class)->states('published')->create(
            ['price' => 500]
        );

        $option = factory(Option::class)->create(
            ['date_id' => $date->id]
        );

        $response = $this->bookAnOptionPost($option, []);

        $response->assertStatus(201);

        $response->assertJsonFragment([
            'date_id' => "{$date->id}",
            'option_id' => $option->id
        ]);

        $this->assertTrue($option->isBooked());
        $this->assertEquals(0, $date->bookingsRemaining());
    }

    /**
     * @test */
    function admin_cannot_book_an_already_booked_option()
    {
        $this->passportLogin();

        $date = factory(Date::class)->states('published')->create(
            ['price' => 500]
        );

        $option1 = factory(Option::class)->create(
            ['date_id' => $date->id]
        );

        $option2 = factory(Option::class)->create(
            ['date_id' => $date->id]
        );

        $responseGood = $this->bookAnOptionPost($option1, []);
        $responseGood->assertStatus(201);

        $response = $this->bookAnOptionPost($option2, []);
        $response->assertStatus(422);

        $this->assertTrue($option1->isBooked());
        $this->assertFalse($option2->isBooked());
    }


}
