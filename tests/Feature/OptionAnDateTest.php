<?php

use App\Date;
use App\Billing\FakePaymentGateway;
use App\Billing\PaymentGateway;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class OptionAnDateTest extends TestCase
{
    use DatabaseMigrations;

    protected $payentGateway;

    protected function setUp()
    {
        parent::setUp();
        $this->paymentGateway = new FakePaymentGateway;
        $this->app->instance(PaymentGateway::class, $this->paymentGateway);
    }

    private function optionADateByPost($date, $params)
    {
        return $this->json('POST', "/api/dates/{$date->id}/options", $params);
    }

    private function assertValidationError($response, $field)
    {
        $response->assertStatus(422);
        $this->assertArrayHasKey($field, $response->decodeResponseJson());
    }

    /** @test */
    function customer_can_claim_an_published_date()
    {
        // Arrange
        $date = factory(Date::class)->states('published')->create(
            ['price' => 500]
        );

        // Act
        $response = $this->optionADateByPost($date, [
            'email' => 'menno@test.com',
            'pax' => 10,
            //'payment_token' => $this->paymentGateway->getValidTestToken()
        ]);


        $response->assertStatus(201);
        $response->assertJsonFragment([
            'email' => 'menno@test.com',
            'pax' => 10,
            'amount' => 5000
        ]);

        //$this->assertEquals(5000, $this->paymentGateway->totalCharges());
        $this->assertNotNull($date->hasOptionsFor('menno@test.com'));
        $this->assertEquals(1, $date->totalOptions());
    }

    /** @test */
    function cannot_option_a_unpublished_date()
    {
        $date = factory(Date::class)->states('unpublished')->create(
            ['price' => 500]
        );

        $response = $this->optionADateByPost($date, [
            'email' => 'menno@test.com',
            'pax' => 10
           // 'payment_token' => $this->paymentGateway->getValidTestToken()
        ]);

        $response->assertStatus(404);
        $this->assertEquals(0, $date->totalOptions());
        //$this->assertEquals(0, $this->paymentGateway->totalCharges());
    }

    function an_option_is_not_created_if_payment_fails()
    {
        $date = factory(Date::class)->states('published')->create();

        $response = $this->optionADateByPost($date,  [
            'email' => 'test@test.com',
            'pax' => 10,
            'payment_token' => 'invalid'
        ]);

        $response->assertStatus(422);
        $this->assertNull($date->hasOptionsFor('test@test.com'));
        $this->assertEquals(1, $date->bookingsRemaining());
    }

    /** @test */
    function cannot_option_a_date_above_200_pax()
    {
        $date = factory(Date::class)->states('published')->create();

        $response = $this->optionADateByPost($date, [
            'email' => 'menno1@test.com',
            'pax' => 201,
            'payment_token' => $this->paymentGateway->getValidTestToken()
        ]);

        $response->assertStatus(422);

        $this->assertNull($date->hasOptionsFor('menno@test.com'));
        $this->assertEquals(0, $date->totalOptions());
        $this->assertEquals(0, $this->paymentGateway->totalCharges());
    }

    /** @test */
    function cannot_option_a_date_thats_already_booked()
    {
        $date = factory(Date::class)->states('published')->create(
            [
                'status' => 2
            ]
        );

        $response = $this->optionADateByPost($date,  [
            'email' => 'menno@test.com',
            'pax' => 10,
            //'payment_token' => $this->paymentGateway->getValidTestToken()
        ]);

        $response->assertStatus(404);

        $this->assertNull($date->hasOptionsFor('menno@test.com'));
        $this->assertEquals(0, $date->totalOptions());
        //$this->assertEquals(0, $this->paymentGateway->totalCharges());
    }

    /** @test */
    function email_is_required_to_option_a_date()
    {
        $date = factory(Date::class)->states('published')->create();

        $response = $this->optionADateByPost($date,  [
            'pax' => 10,
            'payment_token' => $this->paymentGateway->getValidTestToken()
        ]);

        $this->assertValidationError($response, 'email');
    }

    /** @test */
    function email_must_be_valid_to_option_an_date()
    {
        $date = factory(Date::class)->states('published')->create();

        $response = $this->optionADateByPost($date,  [
            'email' => 'geen-valide-email',
            'pax' => 10,
            'payment_token' => $this->paymentGateway->getValidTestToken()
        ]);

        $this->assertValidationError($response, 'email');
    }

    /** @test */
    function option_needs_to_have_pax()
    {
        $date = factory(Date::class)->states('published')->create();

        $response = $this->optionADateByPost($date,  [
            'email' => 'menno@test.com',
            'payment_token' => $this->paymentGateway->getValidTestToken()
        ]);

        $this->assertValidationError($response, 'pax');
    }

    /** @test */
    function pax_needs_to_be_a_least_1_to_order_dates()
    {
        $date = factory(Date::class)->states('published')->create();

        $response = $this->optionADateByPost($date,  [
            'email' => 'menno@test.com',
            'pax' => 0,
            'payment_token' => $this->paymentGateway->getValidTestToken()
        ]);

        $this->assertValidationError($response, 'pax');
    }


    function payment_token_is_required()
    {
        $date = factory(Date::class)->states('published')->create();

        $response = $this->optionADateByPost($date, [
            'email' => 'menno@test.com',
            'pax' => 10
        ]);

        $this->assertValidationError($response, 'payment_token');

    }
}
