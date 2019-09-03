<?php

namespace App\Http\Controllers\Projects;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;

class GuzzleHttpController extends Controller
{
    protected $users = [];
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $client = new Client([
            'headers' => [
                'content-type' => 'application/json',
                'Accept' => 'application/json; text/html'
            ],
        ]);

        $response = $client->request('GET','https://gitlab.iterato.lt/snippets/3/raw',['verify' => false]);

        $result = $response->getBody();
        $data = json_decode($result);

        foreach($data as $value)
        {
            foreach($value as $user)
            {
                $this->users[$user->id] = $user->first_name.' '.$user->last_name;
            }
        }
        return $this->users;
    }

}
