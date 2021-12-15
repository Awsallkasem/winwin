<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\User;
 use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\baseController as baseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class ProductController extends baseController
{


    public function view(){
        $products=product::all();
        $products=$products->where('expirations','>',Carbon::now());
	return $this->success($products,'this is all products');
    }


    public function store(Request $request)
	{

		$validated = Validator::make($request->all(), [
			'name' => 'required|min:2',
			'classification' => 'required',
			'price' => 'required',
			'expirations' => 'required|date:Y-m-d',
			'phone_number' => 'required|max:10',
			'quantity'=>'required',
			'photo'=>'required|mimes:jpeg,png '
		]);

		if ($validated->fails()) {
			return $this->fail($validated->errors());
		}
		$photo=$request->photo;
		$photoname=time().'.'.$photo->getClientOriginalName();

        $request->photo->move(public_path('images'),$photoname);
        $path="public/images /$photoname";
		$end = Carbon::parse($request->expirations);
		$current = Carbon::now();
		$timelimt = $end->diffInDays($current);
		$price=$request->price;
        $price_with_offfer=0;
        if ($timelimt>=30)
			$price_with_offfer=$price*(30/100);

		elseif ($timelimt>=15)
		$price_with_offfer=$price*(50/100);
		   else
			   $price_with_offfer=$price*( 70/100);


		   $creat = product::create([
		   'name' => $request->name,
		   'user_id' => Auth::id(),
		   'classification' => $request->classification,
		   'price' => $price,
           'price_with_offfer'=>$price_with_offfer,
		   'expirations' => $request->expirations,
		   'phone_number' => $request->phone_number,
		   'quantity'=>$request->quantity,
		   'photo'=>$path]);
		return $this->success($request->name,'added successfully');
      }


    public function serach( Request $request)
	{


        $products=product::all();

        $name=$request->name;
        $classification=$request->classification;
        $expirations=$request->expirations;

        if($name){
            $result=$products->where('name','=',$name);
        }

        elseif($classification){
            $result=$products->where('classification','=',$classification);

        }
        elseif($expirations){
            $result=$products->where('expirations','=',$expirations);
        }
     else{
    return $this->fail("please enter any thing");
}

    	}


   public function show_my_products(Request $request){
        $id=Auth::id();
       $product=product::all();
       $result=$product->where('user_id','=',$id);
       $result=$product->where('expirations','>',Carbon::now());
       return $this->success($result,'this your product ');

   }
   public function update(Request $request)
    {

        $validated = Validator::make($request->all(), [
			'name' => 'required',
			'classification' => 'required',
			'price' => 'required',
			'phone_number' => 'required|min:10',
			'quantity'=>'required',
			'photo'=>'required'
		]);
		if ($validated->fails()) {
			return $this->fail($validated->errors());
		}

        $product=product::all();


        $result=$product->where('id','=',$request->id)->pluck('expirations')->first();

		$end = Carbon::parse($result);

		$current = Carbon::now();
		$timelimt = $end->diffInDays($current);
		$price=$request->price;
        $price_with_offfer=0;
        if ($timelimt>=30)
            $price_with_offfer=$price*(30/100);

        elseif ($timelimt>=15)
            $price_with_offfer=$price*(50/100);
        else
            $price_with_offfer=$price*( 70/100);
        $photo=$request->photo;
        $photoname=time().'.'.$photo->getClientOriginalName();

        $request->photo->move(public_path('images'),$photoname);

        $path="public/images /$photoname";

		$create=product::updated([
            'name' => $request->name,
			'classification' => $request->classification,
			'user_id'=>Auth::id(),
			'price' => $price,
			'price' => $price_with_offfer,
			'phone_number' => $request->phone_number,
			'quantity'=>$request->quantity,
			'photo'=>$path
		]);

		return $this->success($request->name,'added successfully');

    }
    public function show_single_product(Request $request){
        $product=product::where('id','=',$request->id)->first();
        $result=$product->pluck('expirations')->first();
        $end = Carbon::parse($result);

        $current = Carbon::now();
       $timelimt = $end->diffInDays($current);
        $price=$product->pluck('price')->first();
        if ($timelimt>  30)
            $price_with_offfer=$price*(30/100);

        elseif ($timelimt>=15)
            $price_with_offfer=$price*(50/100);
        else
            $price_with_offfer=$price*( 70/100);

        $product->price_with_offfer=$price_with_offfer;
        $product->save();
        return $this->success($product,'this is all detial about this product');

    }

    public function destroy(product $product)
    {

    }
}
