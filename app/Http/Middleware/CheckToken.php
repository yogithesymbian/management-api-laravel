<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\TokenManagement;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // get token header
        $token = $request->header('Authorization');
        if (empty($token)) {
            return response()->json([
                'type' => 'error',
                'message' => '',
                'error' => 'Authorization Header is empty',
                'data' => ''
            ]);
        }

        //format bearer token :
        //Bearer[spasi]randomhashtoken
        $pecah_token = explode(" ", $token);
        if(count($pecah_token) <> 2){
            return response()->json([
                'type' => 'error',
                'message' => '',
                'error' => 'Invalid Authorization format',
                'data' => ''
            ]);
        }

        if(trim($pecah_token[0]) <> 'Bearer'){
            return response()->json([
                'type' => 'error',
                'message' => '',
                'error' => 'Authorization header must be a Bearer',
                'data' => ''
            ]);
        }

        $access_token = trim($pecah_token[1]);

        //cek apakah access_token ini ada di database atau tidak
        $cek = TokenManagement::where('access_token', $access_token)->first();
        if(empty($cek)){
            return response()->json([
                'type' => 'error',
                'message' => '',
                'error' => 'Forbidden : Invalid access token',
                'data' => ''
            ]);
        }

        //cek apakah access_token expired atau tidak
        if(strtotime($cek->expired_at) < time() || $cek->is_active != 1){
            return response()->json([
                'type' => 'error',
                'message' => '',
                'error' => 'Forbidden : Token is already expired. ',
                'data' => ''
            ]);
        }


        return $next($request);
    }
}
