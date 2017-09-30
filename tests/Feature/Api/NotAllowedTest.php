<?php

use App\Date;
use App\Option;
use App\Booking;
use Carbon\Carbon;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NotAllowedTest extends TestCase
{
    use DatabaseMigrations;


    /** @test */
    function no_xmlhttprequest_send_return_to_login_page()
    {
        $response = $this->get('/api/dates');
        $response->assertStatus(302);
    }

    /**
     * @test
     */
    function not_authorized_calls_return_the_right_status_code()
    {
        $response = $this->get('/api/dates/1/bookings', ['HTTP_X-Requested-With' => 'XMLHttpRequest']);

        $response->assertStatus(401)->assertJsonFragment([
                'error' => 'Unauthenticated.'
            ]);
    }
}
