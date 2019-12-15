<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

/**
 * @OA\Post(
 *     path="/oauth/token",
 *     tags={"Auth"},
 *     operationId="loginUser",
 *     description="Admin user login",
 *     summary="Logs in user session",
 *     @OA\Header(
 *          header="X-Rate-Limit",
 *          description="calls per hour allowed by the user",
 *          @OA\Schema(
 *              type="integer",
 *              format="int32"
 *          )
 *      ),
 *      @OA\Header(
 *          header="X-Expires-After",
 *          description="date in UTC when token expires",
 *          @OA\Schema(
 *              type="string",
 *              format="datetime"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         description="Login User",
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(ref="#/components/schemas/Auth")
 *         ),
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(ref="#/components/schemas/Auth")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User response",
 *         @OA\JsonContent(ref="#/components/schemas/Auth")
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="unexpected error",
 *         @OA\JsonContent(ref="#/components/schemas/Auth")
 *     )
 * )
 */
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
