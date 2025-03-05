<?php

namespace App\Utilities;

use App\Utilities\Devtools;
use App\Models\Message;
use PHPUnit\Framework\Exception;
use RealRashid\SweetAlert\Facades\Alert;

class MessageMgr {

    /** Gestión de mensajes de aplicación */

    public static $csbYes = 'Y';
    public static $csbNot = 'N';
    public static $csbMessage = 'Mensaje';
    public static $success = 1;
    public static $error = 2;
    public static $warning = 3;
    public static $question = 4;
    public static $info = 5;

    public static $cnuErrorGeneral = -99;
    public static $cnuErrDataNull = 1; // El dato ingresado no puede ser nulo
    public static $cnuErrMessWithParams = 2; // El mensaje indicado [%s1] no recibe parámetros
    public static $cnuErrDataNotExists = 3; // El %s1 ingresado [%s2] no existe configurado en el sistema
    public static $cnuErrMessNotParam = 6; // El mensaje [%s1] requiere parámetros para su visualización

    private static $id_message_title = 4;
    private static $id_message_success = 5;
    private static $id_message_fail = 3;

    /** Retorna valor para variable estatica success */
    public static function getTypeSuccess()
    {
        return self::$success;
    }

    /** Retorna valor para variable estatica error */
    public static function getTypeError()
    {
        return self::$error;
    }

    /** Retorna valor para variable estatica warning */
    public static function getTypeWarning()
    {
        return self::$warning;
    }

    /** Retorna valor para variable estatica question */
    public static function getTypeQuestion()
    {
        return self::$question;
    }

    /** Retorna valor para variable estatica info */
    public static function getTypeInfo()
    {
        return self::$info;
    }

    /** Consulta descripción del código de mensaje consultado */
    static function getMessage($id, $params = null)
    {
        try{
            Devtools::evaluarDatoNulo($id);

            $message = Message::find($id);
            if(empty($message->message))
            {
                throw new Exception(self::getMessage(self::$cnuErrDataNotExists, self::$csbMessage."|".$id));
            }
            switch ($message->params)
            {
                case self::$csbYes:
                    if (!is_null($params))
                    {
                        $i = 1;
                        $arrayParams = explode("|", $params);
                        foreach($arrayParams as $valor)
                        {
                            $message = str_replace("%s".$i, $valor, $message);
                            $i++;
                        }
                    }
                    else
                    {
                        throw new Exception(self::getMessage(self::$cnuErrMessNotParam, $id));
                    }
                    break;
                case self::$csbNot:
                    if (!is_null($params))
                    {
                        throw new Exception(self::getMessage(self::$cnuErrMessWithParams, $id));
                    }
                    break;
                default: return $message;
                    break;
            }
        }
        catch (Exception $e)
        {
            return $e->getMessage();
        }

        return $message;
    }

    private static function setMessage($id, $params)
    {
        $message = json_decode(self::getMessage($id, $params));
        $result = [
            'id' => $message->id,
            'message' => $message->message,
            'cause' => $message->cause,
            'solution' => $message->solution,
            'module_id' => $message->module_id,
        ];
        return $result;
    }

    static function setMessageResponse( $type_mess, $id_message = null, $params = null)
    {
        switch ($type_mess) {
            case 1: //success
                    if (is_null($id_message)) $id_message = self::$id_message_success;
                    $messageSucess = self::setMessage($id_message, $params);
                    $cause = $messageSucess['cause'];
                    $message = $messageSucess['message'];
                    Alert::success($cause, $message)
                        ->persistent(true, false);
                    break;
            case 2: //error
                    if (is_null($id_message)) $id_message = self::$id_message_fail;
                    $messageError = self::setMessage($id_message, $params);
                    $cause = $messageError['cause'];
                    $message = $messageError['message'];
                    $footer = '<p align="center">'. $messageError['solution'] .'</p>';
                    Alert::error($cause, $message)
                        ->footer($footer)
                        ->persistent(true, false);
                    break;
            case 3: //warning
                    if (is_null($id_message)) $id_message = self::$id_message_fail;
                    $messageError = self::setMessage($id_message, $params);
                    $cause = $messageError['cause'];
                    $message = $messageError['message'];
                    $footer = '<p align="center">'. $messageError['solution'] .'</p>';
                    Alert::warning($cause, $message)
                        ->footer($footer)
                        ->persistent(true, false);
                    break;
            case 4: //question
                    if (is_null($id_message)) $id_message = self::$id_message_fail;
                    $messageError = self::setMessage($id_message, $params);
                    $cause = $messageError['cause'];
                    $message = $messageError['message'];
                    $footer = '<p align="center">'. $messageError['solution'] .'</p>';
                    Alert::question($cause, $message)
                        ->persistent(true, false);
                    break;
            case 5: //info
                    if (is_null($id_message)) $id_message = self::$id_message_fail;
                    $messageError = self::setMessage($id_message, $params);
                    $cause = $messageError['cause'];
                    $message = $messageError['message'];
                    $footer = '<p align="center">'. $messageError['solution'] .'</p>';
                    Alert::info($cause, $message)
                        ->footer($footer)
                        ->persistent(true, false);
                    break;
            default: //info
                    if (is_null($id_message)) $id_message = self::$id_message_fail;
                    $messageError = self::setMessage($id_message, $params);
                    $cause = $messageError['cause'];
                    $message = $messageError['message'];
                    $footer = '<p align="center">'. $messageError['solution'] .'</p>';
                    Alert::info($cause, $message)
                        ->footer($footer)
                        ->persistent(true, false);
        };
    }

}
