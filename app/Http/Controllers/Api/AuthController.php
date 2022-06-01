<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
  use ApiResponser;

  /**
   * Register
   */
  public function register(Request $request)
  {
    try {

      $validator = Validator::make($request->all(), [
        'name' => 'required|string|min:3',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:7',
      ]);

      if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
      }

      $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
      ]);

      $success = true;
      $message = 'User register successfully';
    } catch (\Illuminate\Database\QueryException $ex) {
      $success = false;
      $message = $ex->getMessage();
    }

    // response
    $response = [
      'success' => $success,
      'message' => $message,
    ];
    return response()->json($response);
  }

  /**
   * Login
   */
  public function login(Request $request)
  {
    $credentials = $request->validate([
      'email' => ['required'],
      'password' => ['required'],
    ]);

    if (!Auth::attempt($credentials)) {
      return $this->error('User email or password not match', 401);
    }

    return response()->json([
      'email' => $request->email,
      'accessToken' => auth()->user()->createToken('API Token')->plainTextToken
    ]);
  }

  /**
   * Logout
   */
  public function logout()
  {
    try {
      Session::flush();
      $success = true;
      $message = 'Successfully logged out';
    } catch (\Illuminate\Database\QueryException $ex) {
      $success = false;
      $message = $ex->getMessage();
    }

    $response = [
      'success' => $success,
      'message' => $message,
    ];

    return response()->json($response);
  }

  public function confirmPassword(Request $request)
  {
    $user = auth()->user();

    if (Hash::check($request->password, $user->password)) {
      return response()->json([
        'status' => true,
        'message' => 'Password is correct!'
      ]);
    }

    return response()->json([
      'status' => false,
      'message' => 'Password is incorrect!'
    ]);
  }

  public function resetPassword(Request $request)
  {
    $user = auth()->user();

    if (Hash::check($request->password, $user->password)) {
      $user->update(['password' => Hash::make($request->new_password)]);
      return response()->json([
        'status' => true,
        'message' => 'Password changed!'
      ]);
    }

    return response()->json([
      'status' => false,
      'message' => 'Password is incorrect!'
    ]);
  }
}
