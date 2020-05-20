<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Cities;

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
}
