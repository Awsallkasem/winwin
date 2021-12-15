<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
 use Carbon\Carbon;
class test extends Controller
{public function test()
{    //	$dd = Carbon\Carbon::now();
/*$to = Carbon::createFromFormat('Y-m-d H:s:i', '2015-7	-5 3:30:34');
$from = Carbon::createFromFormat('Y-m-d H:s:i', '2015-5-6 9:30:34');

		$diff_in_days = $to->diffInDays($dd);

		print_r($diff_in_days);
*/
$end = Carbon::parse('5-12-2021'); 
$current = Carbon::now();
 $length = $end->diffInDays($current);
 return $length;	}
		}
