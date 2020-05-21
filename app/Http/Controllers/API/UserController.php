<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 

use Illuminate\Support\Facades\Auth; 
use Validator;
use Illuminate\Support\Facades\Hash;
use App\User; 
use App\UserRoles;

class UserController extends Controller 
{
public $successStatus = 200;
/** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(Request $request) { 

        $data = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
           
              $user = Auth::user();
              return   ['success' => true, 'data'=>$user];
        } 
        else{ 
            return ['success' => false, 'message'=>"Incorrect username or password"];
        } 
    }
/** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 

    //Register user 
    //parameters: name,email,age,password and c_password(for confirmatin of password)
    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email', 
            'age' => 'required|numeric',
            'password' => 'required', 
            'c_password' => 'required|same:password', 
        ]);

        if ($validator->fails()) { 
                    return response()->json(['error'=>$validator->errors()], 401);            
            }
         
                $input = $request->all(); 
                $input['password'] = Hash::make($input['password']); 
                $user = User::create($input); 
                $success['token'] =  $user->createToken('MyApp')-> accessToken; 
                $success['name'] =  $user->name;
                $success['id'] = $user->id;
                return response()->json(['success'=>$success], $this-> successStatus); 
    }
    /** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function details() 
    { 
        $user = Auth::user(); 
        return response()->json(['success' => $user], $this-> successStatus); 
    } 

    //Update user information
    //parameters: id(for look up), name,email,age,password and c_password(for confirmatin of password)
    public function updateDetails(Request $request){
       
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email', 
            'age' => 'required|numeric',
            'password' => 'required', 
            'c_password' => 'required|same:password', 
            'role' => 'required'
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
    }

        $input = $request->all(); 
        unset($input['c_password']); 
        $input['password'] = Hash::make($input['password']); 

        $updated = User::whereId($input['id'])
                   ->update($input); 

        return response()->json(['success' => $updated], $this-> successStatus); 
    }

    public function getAllUsers (Request $request){
     
        return response()->json(['data' => User::join('user_roles','users.role','=','user_roles.id')->get(['user_roles.name as role_desc','users.*'])->toArray()], $this-> successStatus); 
      }
  
}