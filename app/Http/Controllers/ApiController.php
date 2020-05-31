<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App\User;
use App\Models\TokenManagement;

class ApiController extends Controller
{
    public function generateToken(Request $request){
    	//expect request : email + password.
    	//if fail will return json response
    	$validate = Validator::make($request->all(), [
    		'email' => 'required|email',
    		'password' => 'required|string'
    	]);
    	if($validate->fails()){
    		//kalau ada salah input, tampilkan error dalam format json
    		return [
				'type' => 'error',
				'message' => 'Invalid Input',
    			'error' => $validate->errors(),
    			'data' => false
    		];
    	}

    	//cek email
    	$cek_user = User::where('email', $request->email)->first();
    	if(empty($cek_user)){
    		return [
				'type' => 'error',
				'message' => 'Invalid Input',
    			'error' => 'Email not found',
    			'data' => false
    		];
    	}

    	//cek password
    	if(!password_verify($request->password, $cek_user->password)){
    		return [
				'type' => 'error',
				'message' => 'Invalid Input',
    			'error' => 'Invalid password provided',
    			'data' => false
    		];
    	}

    	//setelah melewati semua filter diatas, artinya email dan password sudah benar.
    	$token_instance = $this->registerToken($cek_user);
    	return [
			'type' => 'success',
			'message' => '',
    		'error' => false,
    		'data' => $token_instance
    	];
    }

    protected function registerToken(User $user){
    	//generate custom hash sebagai auth token
    	$generated_token = base64_encode(sha1(rand(1, 10000) . uniqid() . time()));
    	//manage token ini akan expired dalam jangka waktu berapa lama
    	$expired = date('Y-m-d H:i:s', strtotime('+1 day'));

    	//proses simpan token ke database
    	$token_instance = new TokenManagement;
    	$token_instance->users_id = $user->id;
    	$token_instance->access_token = $generated_token;
    	$token_instance->expired_at = $expired;
    	$token_instance->is_active = 1;
    	$token_instance->save();

    	//setelah token direcord ke database, kembalikan nilai token ke response
    	return $token_instance;
    }
}
