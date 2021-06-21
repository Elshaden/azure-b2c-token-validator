<?php

namespace App\Http\Controllers;

use App\Actions\Azure\TokenChecker;
use Illuminate\Http\Request;

class AzureTokenValidatorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function ValidateAzureToken(Request $request){

         $this->validate($request,[
             'token'=>'required',
             'client_id' =>'required',
             'tenant'=>'required',
             'policy_name'=>'required',
             'scope'=>'',
             'response_type'=>'',
             ])  ;

         $Checker = new TokenChecker($request)   ;
      $Checked =    $Checker->authenticate();

         if($Checked) {
             return response()->json(['token' => 'valid'], 200);
         }

            return response()->json(['token' => 'not_valid'], 400);

    }
}
