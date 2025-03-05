<?php

namespace App\Utilities;

use App\Utilities\MessageMgr;
use App\Utilities\Devtools;
use App\Models\Parameter;
use PHPUnit\Framework\Exception;

class ParameterMgr {

    /** Gestión de parámetros de aplicación */

    public static $csbParameter = 'Parámetro';

    /** Obtiene valor del parámetro consultado */
    static function getParameterValue($name_)
    {
        try
        {
            Devtools::evaluarDatoNulo($name_);

            $parameter = Parameter::where('name_', $name_)->value('value');
            if(empty($parameter))
            {
                throw new Exception(MessageMgr::getMessage(MessageMgr::$cnuErrDataNotExists, self::$csbParameter."|".$name_));
            }
            return $parameter;
        }
        catch (Exception $e)
        {
            return $e->getMessage();
        }
    }

}
