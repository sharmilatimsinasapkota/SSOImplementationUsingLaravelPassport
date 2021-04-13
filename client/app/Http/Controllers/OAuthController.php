<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\OauthToken;
use DB;

class OAuthController extends Controller
{
    public function redirect()
    {
        $queries = http_build_query([
            'client_id' =>'3',
            'redirect_uri' =>'http://client.testt/oauth/callback',
            'response_type' => 'code',
           // 'scope' => 'view-posts'
        ]);

        return redirect('http://server.testt/oauth/authorize?' . $queries);
    }

    public function callback(Request $request)
    {
        //dd($request->all());

        $response = Http::asForm()->post( 'http://server.testt/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => '3',
            'client_secret'=>'ebWLqFXjtO9V5oZkHSV7sEzxCijNHKZ4DXx20Wxg',
            'redirect_uri' => 'http://client.testt/oauth/callback',
            'code' => $request->code
        ]);
       // dd($response->json());

       /*  Another way starts here without table in database    */
      $request->session()->put($response->json());
      return redirect('/userresources');
       /* using database storing session in database */

       /*
        $response = $response->json();
       DB::table('oauth_tokens')->where('access_token', $response['access_token'])->delete();
        /*
        $request->user()->token()->create([
            'access_token' => $response['access_token'],
            'expires_in' => $response['expires_in'],
            'refresh_token' => $response['refresh_token']
        ]);
        */
       // $array=$request->all();
/*
        OauthToken::create([
            'access_token' => $response['access_token'],
            'expires_in' => $response['expires_in'],
            'refresh_token' => $response['refresh_token']]
        );
        return redirect('/freeresources');
        //or redirect to home

         */
    }

    public function user(Request $request){
        //get access token
        //check sesssion statsu here if it is set or not
        $access_token=$request->session()->get('access_token');
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization'=>'Bearer '.$access_token,
        ])->get('http://server.testt/api/user');

        dd($response->json());
       //return $response->json;
            //check if it send data or not if it doesn't send  the page need to be block
            if(isset($response['id']) && !empty($response['id'])){
                //then only allow  page to execute
                //for every page do this

            }



    }


    public function logout(Request $request){
        //get access token
        //check sesssion statsu here if it is set or not
        $access_token=$request->session()->get('access_token');
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization'=>'Bearer '.$access_token,
        ])->post('http://server.testt/api/logout');

        dd($response->json());
       //return $response->json;
            //check if it send data or not if it doesn't send  the page need to be block
            if(isset($response['id']) && !empty($response['id'])){
                //then only allow  page to execute
                //for every page do this

            }

        }

}
