<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Mail\OTPMail;
use App\Helper\JWTToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{

  function UserRegistration(Request $request){  

  try {

      User::create([
           'firstName'=> $request->input('firstName'),
           'lastName'=> $request->input('lastName'),
           'email'=> $request->input('email'),
           'mobile'=> $request->input('mobile'),
           'password'=> $request->input('password'),
       ]);
   
       return response()->json([
         'status'=> 'Success',
         'message' => 'User Registration Successfully'
       ], 200 );
   
  }
  catch (Exception $e) {

    return response()->json([
      'status'=> 'Failed',
      'message' => $e->getMessage(),
      
    ], 500 );
    
  }
}
}
