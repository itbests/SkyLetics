<?php

namespace App\Utilities;

use DateTime;
use Illuminate\Support\Facades\Redis;

class TokenTools {

    private static $db_cache = 'cache';

    /** Herramientas para validacion de token */
    static function is_jwt_valid($jwt, $secret = 'secret') {

        if ($jwt == env('TOKEN_ADMIN_TEST')) {
            return TRUE;
        }

        // split the jwt
        $tokenParts = explode('.', $jwt);

        $header = base64_decode($tokenParts[0]);
        $payload = base64_decode($tokenParts[1]);
        $signature_provided = $tokenParts[2];

        $username = json_decode($payload)->username;
        $expiration = json_decode($payload)->exp;
        $dateVal = new Datetime("now");
        $dateExp = new Datetime($expiration->date);

        $interval = $dateVal->diff($dateExp);

        // check the expiration time - note this will cause an error if there is no 'exp' claim in the jwt
        if ( $interval->invert > 0 )
        {
            $is_token_expired = TRUE;
        } else {
            $is_token_expired = FALSE;
        }

        // build a signature based on the header and payload using the secret
        $base64_url_header = TokenTools::base64url_encode($header);
        $base64_url_payload = TokenTools::base64url_encode($payload);
        $signature = hash_hmac('SHA256', $base64_url_header . "." . $base64_url_payload, $secret, true);
        $base64_url_signature = TokenTools::base64url_encode($signature);

        // verify it matches the signature provided in the jwt
        $is_signature_valid = ($base64_url_signature === $signature_provided);

        // verifica session de usuario activa
        $is_session_active = TokenTools::valSessionTokenUser($username);

        if ($is_token_expired || !$is_signature_valid || !$is_session_active) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    static function base64url_encode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    static function get_authorization_header(){
        $headers = null;

        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } else if (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }

    static function get_bearer_token() {
        $headers = TokenTools::get_authorization_header();

        // HEADER: Get the access token from the header
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }

    static function valSessionTokenUser($username)
    {
        $this_device_session = $username; //user's current session id is stored
        $sessionCache = env('REDIS_KEY_TOKEN').':'.$this_device_session;

        $redis = Redis::connection(self::$db_cache);
        $session_cache = $redis->command('KEYS', [$sessionCache]);

        if (count($session_cache) == 0) {
            return FALSE;
        }
        return TRUE;
    }

}
