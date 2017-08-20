<?php

use App\Date;
use Carbon\Carbon;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SaveDateTest extends TestCase
{
    use DatabaseMigrations;

    protected $date_from;
    protected $date_to;

    public function setUp()
    {
        $this->date_from = Carbon::parse('+2 day')->toDateTimeString();
        $this->date_to = Carbon::parse('+3 day')->toDateTimeString();
        parent::setUp();
        $this->passportLogin();
    }

    /** @test */
    public function admin_can_save_date_to_database()
    {
        $date = [
            'date_from' => $this->date_from,
            'date_to' => $this->date_to,
            'price' => 520,
            'status' => Date::STATUS_AVAILABLE
        ];

        $response = $this->post('api/dates', $date, ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200)->assertJsonFragment([
            'start' => $this->date_from,
            'end' => $this->date_to,
            'createdAt' => Carbon::now()->toDateTimeString()
        ]);
    }

    /** @test */
    public function admin_cannot_save_an_unvalidated_date()
    {
        $date = [];
        $response = $this->post('api/dates', $date, ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(422)->assertJsonFragment([
            'date_to' => ['The date to field is required.'],
            'date_from' => ['The date from field is required.'],
            'price' => ['The price field is required.'],
            'status' => ['The status field is required.']
        ]);
    }

    /** @test */
    public function admin_can_update_an_existing_date()
    {
        // Make a date
        $date = factory(Date::class)->states('published')->create([
            'date_from' => $this->date_from,
            'date_to' => $this->date_to,
            'price' => 520,
            'admin_id' => 1,
            'status' => Date::STATUS_AVAILABLE
        ]);

        $updateDate = Carbon::parse('+5 day')->toDateTimeString();

        $update = [
            'date_from' => $this->date_from,
            'date_to' => $updateDate,
            'price' => 999,
            'admin_id' => 1,
            'status' => Date::STATUS_NOT_AVAILABLE
        ];

        $response = $this->put('api/dates/' . $date->id, $update, ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200)->assertJsonFragment([
            'start' => $this->date_from,
            'end' => $updateDate,
            'status' => [
                'code' => Date::STATUS_NOT_AVAILABLE,
                'label' => 'Niet beschikbaar'
            ]
        ]);
    }

    /** @test */
    public function admin_cannot_update_an_non_existing_date()
    {
        $updateDate = Carbon::parse('+5 day')->toDateTimeString();

        $update = [
            'date_from' => $this->date_from,
            'date_to' => $updateDate,
            'price' => 999,
            'status' => Date::STATUS_AVAILABLE
        ];

        $response = $this->put('api/dates/1', $update, ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(404)->assertJsonFragment([
            'errors' => [
                'message' => 'Not Found',
                'status_code' => 404
            ]
        ]);
    }

    /**
     * @test
     */
    public function admin_can_add_range_of_weekends()
    {
        $dateFrom = Carbon::parse('1 november 2099')->toDateTimeString();
        $dateTo = Carbon::parse('1 december 2099')->toDateTimeString();

        $range = [
            'only_weekend' => true,
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
            'price' => 522,
            'status' => Date::STATUS_AVAILABLE
        ];

        $response = $this->post('api/dates/range', $range, ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200)->assertJsonFragment([
            'message' => 'Success'
        ]);

        $dates = Date::all();
        $this->assertEquals(count($dates), 4);
    }

    /**
     * @test
     */
    public function admin_cant_add_weeks_if_they_arent_complete()
    {
        $dateFrom = Carbon::parse('1 november 2099')->toDateTimeString();
        $dateTo = Carbon::parse('1 december 2099')->toDateTimeString();

        $range = [
            'only_weekend' => false,
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
            'price' => 522,
            'status' => Date::STATUS_AVAILABLE
        ];

        $response = $this->post('api/dates/range', $range, ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(422)->assertJsonFragment([
            'message' => 'Not a complete week: Please select a complete week in the range'
        ]);

        $dates = Date::all();
        $this->assertEquals(count($dates), 0);
    }

    /**
     * @test
     */
    public function admin_can_add_complete_weeks()
    {
        $dateFrom = Carbon::parse('1 november 2099')->toDateTimeString();
        $dateTo = Carbon::parse('4 december 2099')->toDateTimeString();

        $range = [
            'only_weekend' => false,
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
            'price' => 522,
            'status' => Date::STATUS_AVAILABLE
        ];

        $response = $this->post('api/dates/range', $range, ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200)->assertJsonFragment([
            'message' => 'Success'
        ]);

        $dates = Date::all();
        $this->assertEquals(count($dates), 4);
    }
}
