<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\DB;


class LoginController extends Controller
{

    public $successStatus = 200;
    private $client;

    public function __construct()
    {
        $this->client = Client::where([
            'id' => 6,
            'revoked' => 0
        ])->first();
    }

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $loggedin = Auth::attempt([
            'email' => request('email'),
            'password' => request('password'),
        ]);

        if ($loggedin) {
            $this->getUserClient();

            if ($this->client->count() > 0) {
                $params = [
                    'grant_type' => 'password',
                    'client_id' => $this->client->id,
                    'client_secret' => $this->client->secret,
                    'username' => request('email'),
                    'password' => request('password'),
                    'scope' => '*'
                ];

                return $this->requestOAuthToken($request, $params);
            }
        }

        return response()->json(['error' => 'Unauthorised'], 401);

    }

    /**
     * Refresh token for current user
     *
     * @param Request $request
     * @return mixed
     */
    public function refresh(Request $request)
    {
        $this->validate($request, [
            'refresh_token' => 'required'
        ]);


        $params = [
            'grant_type' => 'refresh_token',
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'username' => request('email'),
            'password' => request('password'),
            'scope' => '*'
        ];

        return $this->requestOAuthToken($request, $params);
    }

    public function logout(Request $request)
    {
        $accessToken = Auth::user()->token();

        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update(['revoked' => true]);

        $accessToken->revoke();
        return response()->json([], 204);
    }


    /**
     * Dispatch 0Auth Token
     *
     * @param Request $request
     * @param $params
     * @return mixed
     */
    private function requestOAuthToken(Request $request, $params)
    {
        $request->request->add($params);
        $proxy = Request::create('oauth/token', 'POST');

        return Route::dispatch($proxy);
    }

    /**
     * Get user client
     *
     * @return void
     */
    private function getUserClient()
    {
        $user = Auth::user();
        $this->client = Client::where([
            'user_id' => $user->id,
            'revoked' => 0
        ])->first();
    }
}