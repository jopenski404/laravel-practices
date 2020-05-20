<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Cities;
use Validator;

class CitiesController extends Controller
{
    public $successStatus = 200;
    public function list(){ 
        return response()->json(['success' => Cities::all()], $this-> successStatus); 
    }
    public function getCity (Request $request){
      //  $city = Cities::where('id',$city_id)->first();
        return response()->json(['success' => Cities::whereId($request['id'])->first()], $this-> successStatus); 
    }
    public function addCity(Request $request){
        
        //use validator to set each fields for validaton
        $validator = Validator::make($request->all(), [ 
            'name' => 'required',  
        ]);

        //return error if name is null in the parameters
        if ($validator->fails()) { 
                    return response()->json(['error'=>$validator->errors()], 401);            
        }

        $input = $request->all(); 
        $city = Cities::create($input); 
        $success['name'] =  $city->name;
        return response()->json(['success'=>$success], $this-> successStatus); 
    }
}
