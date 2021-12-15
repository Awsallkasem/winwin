<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class baseController extends Controller
{
    public function success($dataa ,$message)
    {$data=[
            'success'=>true,
        'data'=>$dataa,
        'message'=>$message
];
        return response()->json([$data,200]);
}
public function fail($errorMessage=[]){
	$data['success']=false;
		if (!is_null($errorMessage))
			$data['asd']=$errorMessage;


    return response()->json([$data,404]);


}
}
