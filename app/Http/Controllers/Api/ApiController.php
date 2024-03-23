<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Admin_Image;
use App\Models\Admin_Profile;
use App\Models\Bio;
use App\Models\Education;
use App\Models\Experiance;
use App\Models\Image;
use App\Models\Interesting;
use App\Models\Profile;
use App\Models\Skills;
use App\Models\User;
use App\Models\User_Image;
use App\Models\User_Profile;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
//user!!
public function user_register(Request $request){
      //validation

$request->validate([ 'name'=>"required",'password'=>'required|confirmed',]);

if($request->input("communication")=="email")
{

$request->validate(['email'=>"required|email"]);
}

else {
$request->validate(['phone'=>'required']);
}
//end validation
try{
 if($request->communication=="email" )
 {
    $user=User::create([
        'name'=>$request->name,
        "email"=>$request->email,
        'password'=>Hash::make($request->password),
         ]);


        //$user=User::where('email',$request->email)->first();
//$user->generateCode();


        if( auth()->guard('user')->attempt(['email'=>$request->email,'password'=>$request->password]))
        {
//////
    $user=User::where('email',$request->email)->first();
        $token=$user->createToken('my token',['user'])->accessToken;

        }
        return response()->json(['status'=>true,'message'=>'you are register successfully',"token"=>$token]);


        }
    else
    if($request->communication=="phone"){
    $user=User::create([
           'name'=>$request->name,
           'phone'=>$request->phone,
           'password'=>Hash::make($request->password),
         ]);


        //$user=User::where('phone',$request->phone)->first();
        //$user->generateCode();
        if( auth()->guard('user')->attempt(['phone' => $request->phone, 'password' => $request->password]))
        {

    $user=User::where('phone',$request->phone)->first();
        $token=$user->createToken('my token',['user'])->accessToken;

        }
        return response()->json(['status'=>true,'message'=>'you are register successfully',"token"=>$token]);

        }


    //return response()->json(['status'=>true,'message'=>'you are register successfully']);
    }
    catch (QueryException $e)
     {
        // If a duplicate entry error occurs (e.g., duplicate email)
                if ($e->errorInfo[1] == 1062)
                  return response()->json(['status'=>false,'email'=>'This email is already registered.']);
                 else return response()->json(['status'=>false,'message'=>'Try again']);}

    }


public function user_login(Request $request){

    if($request->input('communication')=='email')

    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);


        if( auth()->guard('user')->attempt(['email' => $request->email, 'password' => $request->password]))
        {

    $user=User::where('email',$request->email)->first();
        $token=$user->createToken('my token',['user'])->accessToken;

        return response()->json(['status'=>true,'token'=>$token]);

        }

    }

     else
     if($request->input('communication')=='phone')
     {

        $request->validate([
            'phone'=>'required',
            'password'=>'required'
        ]);


        if( auth()->guard('user')->attempt(['phone' => $request->phone, 'password' => $request->password]))
        {

    $user=User::where('phone',$request->phone)->first();
        $token=$user->createToken('my token',['user'])->accessToken;

        return response()->json(['status'=>true,'token'=>$token]);
        }
     }
         return response()->json(['status'=>false,'message'=>'invalid logged in details']);





                            }





public function user_logout(){
    Auth::guard('user-api')->user()->token()->revoke();

    return response()->json(['status'=>true,'message'=>"you are loggout successfully"]);



}

public function user_refreshtoken(Request $request){


    $request->user()->tokens()->delete(); // Revoke all existing tokens
    $token = $request->user()->createToken('my token',['user'])->accessToken;

    return response()->json([
        'token' => $token,
    ]);


}


public function user_create_profile(Request $request){
$request->validate(['first_name'=>'required','last_name'=>'required','age'=>'required','user_id'=>'required']);
try{

       $profile= User_Profile::create(['first_name'=>$request->first_name,'middle_name'=>$request->middle_name,
       'last_name'=>$request->last_name,'age'=>$request->age,'gender'=>$request->gender,'user_id'=>$request->user_id]);

    return response()->json(['status'=>true,'message'=>'you,r profile is ','profile'=>$profile]);

}

catch (QueryException $e)
{ return response()->json(['status'=>false,'message'=>'Try again']);}



}

public function user_image(Request $request)
{
$request->validate(['path'=>'required','user_id'=>'required']);
try{
$image=User_Image::create(['path'=>$request->path,'user_id'=>$request->user_id]);
return response()->json(['status'=>true,'image'=>$image]);
}

catch (QueryException $e)
    { return response()->json(['status'=>false,'message'=>'Try again']);}

}

public function education(Request $request)
{

$request->validate(['name'=>'required','type'=>'required','grade'=>'required','first_date'=>'required','last_date'=>'required']);
try{

    $education=Education::create(['name'=>$request->name,'type'=>$request->type,'grade'=>$request->grade,'first_date'=>$request->first_date,'last_date'=>$request->last_date]);
   return response()->json(['status'=>true,'message'=>$education]);
}

catch (QueryException $e)
    { return response()->json(['status'=>false,'message'=>'Try again']);}

}




public function experiance(Request $request)
{


    $request->validate(['name'=>'required','description'=>'required','first_date'=>'required','last_date'=>'required','company_name'=>'required']);

    try{

        $experiance=Experiance::create(['name'=>$request->name,'description'=>$request->description,'company_name'=>$request->company_name,'first_date'=>$request->first_date,'last_date'=>$request->last_date]);
        return response()->json(['status'=>true,'message'=>$experiance]);
     }


    catch (QueryException $e)
        { return response()->json(['status'=>false,'message'=>'Try again']);}

    }




public function skills(Request $request)
{


    $request->validate(['name'=>'required']);
    try{
        $skills=Skills::create(['name'=>$request->name]);
        return response()->json(['status'=>true,'message'=>$skills]);


    }

    catch (QueryException $e)
        { return response()->json(['status'=>false,'message'=>'Try again']);}

    }






public function interestings(Request $request)
{
    $request->validate(['name'=>'required']);

    try{
        $interestings=Interesting::create(['name'=>$request->name]);
        return response()->json(['status'=>true,'message'=>$interestings]);
    }
    catch (QueryException $e)
        { return response()->json(['status'=>false,'message'=>'Try again']);}

}



















//admin
public function admin_register(Request $request){
//validation

$request->validate([ 'company_name'=>"required",'email'=>'required|email','password'=>'required|confirmed',]);
try{
$admin=Admin::create(['company_name'=>$request->company_name,'email'=>$request->email,'password'=>Hash::make($request->password)]);
if(auth()->guard('admin')->attempt(['email' => $request->email, 'password' => $request->password]))
        {

$admin=Admin::where('email',$request->email)->first();
        $token=$admin->createToken('my token',['admin'])->accessToken;

        }
        return response()->json(['status'=>true,'message'=>'you are register successfully','token'=>$token]);}
        catch (QueryException $e)
        {
           // If a duplicate entry error occurs (e.g., duplicate email)
                   if ($e->errorInfo[1] == 1062)
                     return response()->json(['status'=>false,'email'=>'This email is already registered.']);
                    else return response()->json(['status'=>false,'message'=>'Try again']);}













}

public function admin_login(Request $request){
//validation
$request->validate(['email'=>'required|email','password'=>'required']);
if( auth()->guard('admin')->attempt(['email'=>$request->email,'password'=>$request->password]))
        {

   $admin=Admin::where('email',$request->email)->first();

        $token=$admin->createToken('my token',['admin'])->accessToken;


        return response()->json(['status'=>true,'token'=>$token]);

        }
 return response()->json(['status'=>false,'message'=>'invalid logged in details']);



}


public function admin_logout(){

    Auth::guard('admin-api')->user()->token()->revoke();

     return response()->json(['status'=>true,'message'=>"you are loggout successfully"]);

}

public function admin_refreshtoken(Request $request){

    $request->user()->tokens()->delete(); // Revoke all existing tokens
    $token = $request->user()->createToken('my token',['admin'])->accessToken;

    return response()->json([
        'token' => $token,
    ]);
}

public function admin_create_profile(Request $request)
{
$request->validate(['location'=>'required','link'=>'required','admin_id'=>'required','created_date'=>'required']);
try{

    $profile=Admin_Profile::create(['location'=>$request->location,'link'=>$request->link,'created_date'=>$request->created_date,'admin_id'=>$request->admin_id]);
    return response()->json(['status'=>true,'message'=>'you are profile is created successfully ','profile'=>$profile]);
}




catch (QueryException $e)
{ return response()->json(['status'=>false,'message'=>'Try again']);}

}


public function admin_image(Request $request)
{
$request->validate(['path'=>'required','admin_id'=>'required']);
try{
$image=Admin_Image::create(['path'=>$request->path,'admin_id'=>$request->admin_id]);
return response()->json(['status'=>true,'image'=>$image]);
}

catch (QueryException $e)
    { return response()->json(['status'=>false,'message'=>'Try again']);}

}


// public function image_profile(Request $request){
//     $request->validate(['path']);
//     if($request->belongesto=="user"){
//         $request->validate(['user_id']);

//         try{
//             $image=Image::create(['path'=>$request->path,'user_id'=>$request->user_id,'admin_id'=>null]);

//             return response()->json(['status'=>true,'image:'=>$image]);
//         }

// catch (QueryException $e)
// { return response()->json(['status'=>false,'message'=>'Try again']);}
// }


//         else
//         if($request->belongesto=="admin"){
//           $request->validate(['admin_id']);
// try{
// $image=Image::create(['path'=>$request->path,'admin_id'=>$request->admin_id,'user_id'=>null]);
// return response()->json(['status'=>true,'image:'=>$image]);
// }

// catch (QueryException $e)
//     { return response()->json(['status'=>false,'message'=>'Try again']);}
// }
// }

public function bio(Request $request){

    $request->validate(['body'=>'required']);
    try{
$bio=Bio::create(['body'=>$request->body]);
return response()->json(['status'=>true,'body'=>$bio]);
    }
    catch (QueryException $e)
       { return response()->json(['status'=>false,'message'=>'Try again']);}

}

public function bio_show(){
    try{

$bio=Bio::where('id',Auth::user()->id)->first();
            return response()->json(['status'=>true,'bio'=>$bio]);
        }
        catch (QueryException $e)
        { return response()->json(['status'=>false,'message'=>'Try again']);}

}





















}











