<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
   // return $request->user();

   return $request->user();

});





//Route::middleware('auth:api')->get('/logout', [App\Http\Controllers\UserController::class, 'logout']);
Route::middleware('auth:api')->post('/logout', function (Request $request) {
    // Revoke access token
    // => Set oauth_access_tokens.revoked to TRUE (t)
    $request->user()->token()->revoke();

    Illuminate\Support\Facades\DB::table('sessions')
    ->whereUserId($request->user()->id)
    ->delete();
    // Revoke all of the token's refresh tokens
    // => Set oauth_refresh_tokens.revoked to TRUE (t)
    $refreshTokenRepository = app('Laravel\Passport\RefreshTokenRepository');
    $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($request->user()->token()->id);

    return;
});
