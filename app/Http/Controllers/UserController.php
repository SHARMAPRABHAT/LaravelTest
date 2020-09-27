<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\UserDetail;
use App\Http\Controllers\Http;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Storage;
use File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function __construct()
    {}

    public function createUser(Request $request)
    {
        $payload   = $request->all();
        $request  = $request->create('/api/registerWithApi/', 'POST',  $payload, [],$_FILES );
        $response = json_decode(app()->handle($request)->getContent(),true);

        print_r($response );die('ds');
        if(!$response['status']) {
            return back()->with('user_err',$response['message']);
        }
        else {
            return back()->with('user_sucess',$response['message']);
        }
        
    }

    public function registerWithApi(Request $request)
    {   
        $rules = [
            'name'          => 'required',
            'email'         => 'required',
            'password'      => 'required',
            'fname'         => 'required',
            'mname'         => 'required',
            'address'       => 'required',
            'profileImg'    => 'required'
        ];

        $validationMessages = [
            'name.required'         => 'Please Enter Name.',
            'email.required'        => 'Please Enter email.',
            'password.required'     => 'Please Enter Password.',
            'fname.required'        => 'Please Enter Father Name.',
            'mname.required'        => 'Please Enter Mother Name.',
            'address.required'      => 'Please Enter Father Address.',
            'profileImg.required'   => 'Profile Img is mising.',
        ];

        $validator = Validator::make($request->all(), $rules, $validationMessages);
        if ($validator->fails()) 
        {
            $code = 200;
            $output = [
                'code'    => $code,
                'status'  => false,
                'message' => $validator->errors()->all(),
                'result'  => ''
            ];

            return response()->json($output,$code);
        }
        $payload   = $request->all();
        $file      = $request->file('profileImg');
        $filename  = $file->getClientOriginalName();
        $tmpPhoto   = rand().'~'.time().'_'.$filename;
        $storage = Storage::disk('img')->put($tmpPhoto,File::get($file));
   
        if(!empty($payload['id'])){
            $user = User::find($payload['id']);
            $userData =User::where('id',$payload['id'])->pluck('email')->first();;
            
            if($userData->email != $payload['email']) {
                $user->email = $payload['email'];
            }
        }
        else{
            $user = new User();
            $user->email        = $payload['email'];
        }
        
        $user->password     = app('hash')->make($payload['password']);
        $user->name         = $payload['name'];
        $user->profile_img  = $tmpPhoto;
        $user->save();
        
        if(!empty($payload['id'])){
            $userDetails = UserDetail::where('user_id',$payload['id']);
        }
        else{
            $userDetails = new UserDetail();
        }
        
        $userDetails->fname     = $payload['fname'];
        $userDetails->mname     = $payload['mname'];
        $userDetails->address   = $payload['address'];
        $userDetails->user_id   = $user->id;
        $userDetails->save();

        $file      = $request->file('profileImg');
        $filename  = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension(); 
        $tmpPhoto   = rand().'~'.time().'_'.$filename;
        Storage::disk('img')->put($tmpPhoto,File::get($file));

        $code = 200;
        $output = [
            'code'    => $code,
            'status'  => true,
            'message' => !empty($payload['id']) ? 'Updated Successfully': 'Registed Successful',
            'result'  => ''
        ];

        return response()->json($output,$code);
    }

    public function loginUser(Request $request)
    {
        $payload    = $request->all();
        $request    = $request->create('/api/auth/login', 'POST',  $payload);
        $response   = json_decode(app()->handle($request)->getContent(),true);
        $status     = app()->handle($request)->status();
        
        if($status == 200) {
            setcookie('token', $response['token'], time() + (86400 * 30), "/");
            return redirect('/dashboard');
        }
        else {
            return back()->with('login_err',$response['message']);
        }
    }

    public function dashboard(Request $request)
    {   
        
        $request    = $request->create('/api/auth/payload', 'POST',  [ 'token'=>$_COOKIE['token']]);
        $response   = json_decode(app()->handle($request)->getContent(),true);
        $status = app()->handle($request)->status();
        
        if($status==200){
            $Data = User::leftJoin('user_details', 'users.id', '=', 'user_details.user_id')
                ->where('email',$response['email'])
                ->select('users.email','users.password','users.name','user_details.fname','user_details.mname','users.id as id','user_details.address')
                ->first();
            return view('dashbord',compact('Data'));
        }
        else {
            return redirect('/');    
        }
    }
}
