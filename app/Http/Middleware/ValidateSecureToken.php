<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Utilities\TokenTools;
use App\Utilities\Devtools;
use App\Utilities\MessageMgr;
use PHPUnit\Framework\Exception;

class ValidateSecureToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public static $cnuErrServ = 5;

    public function handle(Request $request, Closure $next)
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST");

        $bearer_token = TokenTools::get_bearer_token();
        $ctrlNull = Devtools::evaluarDatoNulo($bearer_token, 'Bearer Token');

        if(is_bool($ctrlNull)){
            $is_jwt_valid = TokenTools::is_jwt_valid($bearer_token);

            if ( !$is_jwt_valid )
            {
                //Error de conexion por token invalido
                $messageError = [
                    'error_code' => -99,
                    'error_message' => json_decode(MessageMgr::getMessage(self::$cnuErrServ, 'Token Invalido')),
                ];

                return response()->json([
                    'status' => false,
                    'message' => $messageError,
                ], 200);
            }
        }else{
            if(!is_null($ctrlNull))
            {
                //Error token null
                $messageError = [
                    'error_code' => -99,
                    'error_message' => json_decode($ctrlNull),
                ];

                return response()->json([
                    'status' => false,
                    'message' => $messageError,
                ], 200);
            }
        }

        return $next($request);
    }
}
