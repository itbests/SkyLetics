<?php

namespace App\Utilities;

use DateTime;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;

class Sessiontools {

    private static $db = 'user_session';

    /** Herramientas para manejo de sesión usuario */

    /** Registra sesión por usuario conectado */
    static function sessionRegister()
    {
        $user_id = Auth::user()->id;
        $this_device_session = Session::getId(); //user's current session id is stored

        $dataSession = [];
        $dataSession = json_encode(array('current_session'=>$this_device_session, 'last_login'=>date("Y-m-d H:i:s"), 'browser'=>$_SERVER["HTTP_USER_AGENT"] ));
        $userSession = $user_id.'_'.$this_device_session;

        $redis = Redis::connection(self::$db);
        $redis->set($userSession, $dataSession);

        $headers = array('alg'=>'HS256','typ'=>'JWT');
        $expiration = new DateTime();
        $expiration->modify( '+'.env('SESSION_LIFETIME').' minute' );
		$payload = array('username'=>$this_device_session, 'exp'=>$expiration);
		$jwt = Sessiontools::generate_jwt($headers, $payload);
        $redis->set('jwt_'.$userSession, $jwt);
    }

    static function countSessionActive()
    {
        $user_id = Auth::user()->id;

        $redis = Redis::connection(self::$db);
        $user_sessions = $redis->command('KEYS', [$user_id.'_*']);

        return count($user_sessions);
    }

    static function valCurrentSession()
    {
        $user_id = Auth::user()->id;
        $this_device_session = Session::getId(); //user's current session id is stored
        $userSession = $user_id.'_'.$this_device_session;

        //dd($this_device_session);

        $redis = Redis::connection(self::$db);
        $user_sessions = $redis->command('KEYS', [$userSession]);

        return count($user_sessions);
    }

    static function logoutByLoginOtherBrowser()
    {
        $user_id = Auth::user()->id;
        $this_device_session = Session::getId(); //user's current session id is stored
        $redis = Redis::connection(self::$db);
        $userSession = $user_id.'_'.$this_device_session;

        $user_sessions = $redis->command('KEYS', [$user_id.'_*']);
        foreach( $user_sessions AS $key )
        {
            $posIni = strlen( env('REDIS_PREFIX', 'db_') );
            $key = substr( $key, $posIni );
            if ( $key != $userSession ) {
                $redis->command('DEL', [$key]);
            }
        }
    }

    static function getMenuUserSession(){
        $menuJson = session('menuUser');
        $menu = json_decode($menuJson, TRUE);
        return $menu[0];
    }

    static function generate_jwt($headers, $payload, $secret = 'secret') {
        $headers_encoded = Sessiontools::base64url_encode(json_encode($headers));

        $payload_encoded = Sessiontools::base64url_encode(json_encode($payload));

        $signature = hash_hmac('SHA256', "$headers_encoded.$payload_encoded", $secret, true);
        $signature_encoded = Sessiontools::base64url_encode($signature);
        $jwt = "$headers_encoded.$payload_encoded.$signature_encoded";

        return $jwt;
    }

    static function base64url_encode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

}
