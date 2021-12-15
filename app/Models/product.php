<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{   protected $table="products";
	use HasFactory;
	protected $fillable = [
		'name',
		'classification',
		'price',
		'expirations',
		'phone_number',
        'photo',
        'price_with_offfer',
		'quantity',
        'user_id'
	];
	public function user()
	{
		return $this->belongsTo(User::class);
	}}
