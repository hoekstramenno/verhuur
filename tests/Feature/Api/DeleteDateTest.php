<?php

use App\Date;
use Carbon\Carbon;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DeleteDateTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var string
     */
    protected $date_from;

    /**
     * @var string
     */
    protected $date_to;

    /**
     * Setup of class
     */
    public function setUp()
    {
        $this->date_from = Carbon::parse('+2 day')->toDateTimeString();
        $this->date_to = Carbon::parse('+3 day')->toDateTimeString();
        parent::setUp();
        $this->passportLogin();
    }
    /**
     * @test
     */
    public function admin_can_delete_a_date()
    {
        $date = factory(Date::class)->states('published')->create([
            'date_from' => $this->date_from,
            'date_to' => $this->date_to,
            'price' => 520,
            'admin_id' => 1,
            'status' => Date::STATUS_AVAILABLE
        ]);

        $response = $this->delete('api/dates/' . $date->id, ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(200)->assertJsonFragment([
            'message' => "Success"
        ]);

        $deletedDate = Date::where('id', $date->id)->first();
        $this->assertNull($deletedDate);

    }

    /**
     * @test
     */
    public function admin_cant_delete_an_nonexisting_date()
    {

    }
}