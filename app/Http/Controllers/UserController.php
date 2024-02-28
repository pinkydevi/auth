<?php

namespace App\Http\Controllers;


use Exception;
use App\Models\User;
use App\Mail\OTPMail;
use App\Helper\JWTToken;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class UserController extends Controller
{
  function LoginPage():View{
     return view('pages.auth.login-page');
    
  }

  function RegistrationPage():View{
    return view('pages.auth.registration-page');
  }

  function SendOTPCodePage():View{
    return view('pages.auth.send-otp-page');
  }

  function VerifyOTPPage():View{
    return view('pages.auth.verify-otp-page');
  }

  function ResetPassPage():View{
    return view('pages.auth.reset-pass-page');
  } 
  
  function UserProfile(Request $request){
    return Auth::user();
}








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
      
    ], 200 );
    
  }
}

function UserLogin(Request $request){
    
    $count = User::where('email','=',$request->input('email'))
          ->where('password','=',$request->input('password'))
          ->count();

          if($count == 1){
            //User Login->JWT Token Issue
            $token = JWTToken::CreateToken($request->input('email'));

            return response()->json([
                'status'=>'success',
                'message'=>'User Login Successfully',
                'token'=>$token
            ],200);


          }
          else{

            return response()->json([
                'status' => 'failed',
                'message' => 'unauthorized'
            ],200);

          }

}

function SendOTPCode(Request $request){
    $email=$request->input('email');
    $otp=rand(1000,9999);
    $count=User::where('email','=',$email)->count();

    if($count==1){
        //Otp Email Address

        Mail::to($email)->send(new OTPMail($otp));
        //Otp Code table update
        User::where('email','=',$email)->update(['otp'=>$otp]);

        return response()->json([
            'status'=>'success',
            'message'=>'4 digit OTP Code has been send to your email'
        ],200);

    }
    else{

        return response()->json([
            'status'=>'failed',
            'message'=>'unauthorized'
        ],200);
    }


}

function VerifyOTP(Request $request){
    $email=$request->input('email');
    $otp=$request->input('otp');
    $count=User::where('email','=',$email)
                 ->where('otp','=',$otp)->count();

    if($count == 1)
    {
        //Database Otp Update
        User::where('email','=',$email)->update(['otp'=>0]);


        //Password Reset Token Issue

        $token = JWTToken::CreateTokenForSetPassword($request->input('email'));

        return response()->json([
            'status'=>'success',
            'message'=>'OTP Verification Successfully',
            'token'=>$token
        ],200)->cookie('token',$token,60*24*30);
  }
    else{

        return response()->json([
            'status'=>'failed',
            'message'=>'unauthorized'
        ],200);
    }
}

function ResetPass(Request $request){
  // dd('hello');

 try{

  $email=$request->header('email');
  // $email='pinkydevi456u@gmail.com';
 $password=$request->input('password');
  // $password='789';

  //  dd ($email,$password);
  User::where('email','=',$email)->update(['password'=>$password]);


  return response()->json([
    'status'=>'success',
    'message'=>'Request Successfully',
    
],200);


 }

 catch(Exception $exception){

  return response()->json([
    'status'=>'fail',
    'message'=>'Something Went Wrong'
],200);
 }


}



}
