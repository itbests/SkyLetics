<?php

namespace App\Utilities;

use App\Utilities\MessageMgr;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Exception;
use Illuminate\Support\Facades\DB;

class Devtools {

    /** Herramientas de desarrollo IT Bests */

    /** Valida dato null */
    static function evaluarDatoNulo($data, $token = null)
    {
        try
        {
            if(is_null($data))
            {
                throw new Exception(MessageMgr::getMessage(MessageMgr::$cnuErrDataNull, $token));
            }
            return true;
        }
        catch (Exception $e)
        {
            return $e->getMessage();
        }
    }

    static function setDataAudit()
    {
        $user_id = Auth::id();

        if(is_null($user_id) || empty($user_id))
            $user_id = ParameterMgr::getParameterValue('DEFAULT_USER');

        $data = array(
            array('USER_ID', $user_id),
            array('TERMINAL', Devtools::getTerminal())
        );

        for($i=0; $i<count($data); $i++)
        {
            $token = $data[$i][0];
            $value = $data[$i][1];
            $sql = "select set_session(?,?)";
            DB::select($sql, array($token, $value));
        }
    }

    static function getTerminal()
    {
        if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"),"unknown"))
            $ip = getenv("HTTP_CLIENT_IP");
        else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
            $ip = getenv("REMOTE_ADDR");
        else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
            $ip = $_SERVER['REMOTE_ADDR'];
        else
            $ip = "IP desconocida";

        return($ip);
    }

    static function beginTransaction()
    {
        DB::beginTransaction();
    }

    static function commit()
    {
        DB::commit();
    }

    static function rollback()
    {
        DB::rollBack();
    }

}
