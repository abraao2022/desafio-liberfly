<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

/**
 * @OA\SecurityScheme(
 *     type="http",
 *     description="Login with email and password to get the authentication token",
 *     name="Token based authentication",
 *     in="header",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="apiAuth",
 * )
 */
class AuthController extends Controller
{
    /**
     * Register a new user.
     *
     * @OA\Post(
     *      path="/api/register",
     *      operationId="registerUser",
     *      tags={"Authentication"},
     *      summary="Register a new user",
     *      description="Register a new user with name, email, and password.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="name", type="string", example="John Doe"),
     *                  @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *                  @OA\Property(property="password", type="string", format="password", example="password"),
     *                  @OA\Property(property="password_confirmation", type="string", format="password", example="password"),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User registered successfully"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation errors"
     *      )
     * )
     */
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        return response()->json(['message' => 'User registered successfully']);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @OA\Post(
     *      path="/api/login",
     *      operationId="loginUser",
     *      tags={"Authentication"},
     *      summary="Login",
     *      description="Login with email and password to get the authentication token.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *                  @OA\Property(property="password", type="string", format="password", example="password"),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="access_token", type="string", description="JWT token"),
     *              @OA\Property(property="token_type", type="string", example="bearer"),
     *              @OA\Property(property="expires_in", type="integer", example="3600", description="Token expiration time in seconds"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *      )
     * )
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @OA\Get(
     *      path="/api/me",
     *      operationId="getAuthenticatedUser",
     *      tags={"Authentication"},
     *      summary="Get the authenticated user",
     *      description="Get the details of the authenticated user.",
     *      security={{"apiAuth": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer", description="User ID"),
     *              @OA\Property(property="name", type="string", description="User name"),
     *              @OA\Property(property="email", type="string", format="email", description="User email"),
     *              @OA\Property(property="created_at", type="string", format="date-time", description="User registration date"),
     *              @OA\Property(property="updated_at", type="string", format="date-time", description="User last update date"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     * )
     */
    public function me()
    {
        return response()->json(Auth::user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @OA\Post(
     *      path="/api/logout",
     *      operationId="logoutUser",
     *      tags={"Authentication"},
     *      summary="Logout",
     *      description="Invalidate the authentication token.",
     *      security={{"apiAuth": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successfully logged out"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     * )
     */
    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @OA\Post(
     *      path="/api/refresh",
     *      operationId="refreshToken",
     *      tags={"Authentication"},
     *      summary="Refresh token",
     *      description="Refresh the authentication token.",
     *      security={{"apiAuth": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="access_token", type="string", description="JWT token"),
     *              @OA\Property(property="token_type", type="string", example="bearer"),
     *              @OA\Property(property="expires_in", type="integer", example="3600", description="Token expiration time in seconds"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     * )
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }
}
