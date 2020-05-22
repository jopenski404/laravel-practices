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

        $credential = $request->only(['email', 'password']);
 
        $user = User::where('email', $credential['email'])->first();
 
        if (!$user || !Hash::check($credential['password'], $user->password)) {
            return response()->json(['message' => 'invalid credentials'], 400);
        }
 
        return response()->json(
            ['token' => $user->createToken($user->name)->plainTextToken, 'user'=> $user],
            200
        );
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
            'firstname' => ['required', 'alpha', 'max:50'],
            'lastname' => ['required', 'alpha', 'max:50'],
            'email' => ['required', 'string', 'email', 'unique:users', 'max:50'],
            'password' => [
                'required',
                'string',
                'min:8', // must be at least 10 characters in length
                'regex:/[a-z]/', // must contain at least one lowercase letter
                'regex:/[A-Z]/', // must contain at least one uppercase letter
                'regex:/[0-9]/', // must contain at least one digit
                'regex:/[\W]/', // must contain a special character],
                'confirmed',
            ],
        ], ['password.regex' => ':attribute must contain lower and upper case letter, number and special character ']);

 

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
            'role' => 'required'
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator], 401);            
    }

        $input = $request->all(); 
        unset($input['c_password']); 
        $input['password'] = Hash::make($input['password']); 

        $updated = User::whereId($input['id'])
                   ->update($input); 

        return response()->json(['data' => $updated]); 
    }

    public function getAllUsers (Request $request){
     
        return response()->json(['data' => User::join('user_roles','users.role','=','user_roles.id')->get(['user_roles.name as role_desc','users.*'])->toArray()], $this-> successStatus); 
      }
    public function getAllRoles (Request $request){
     
        return response()->json(['data' => UserRoles::all()]); 
      }
  
}