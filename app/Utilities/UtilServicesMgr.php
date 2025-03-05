<?php

namespace App\Utilities;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

use App\Models\Menu;
use App\Utilities\MessageMgr;

class UtilServicesMgr {

    private static $db = 'user_session';
    protected $redirectTo = 'app/operatingUnit';
    private $client;
    private $url;

    private function initService($jsonParams)
    {
        $user_id = Auth::user()->id;
        $this_device_session = Session::getId(); //user's current session id is stored
        $key = 'jwt_'.$user_id.'_'.$this_device_session;
        $redis = Redis::connection(self::$db);
        $token = $redis->get($key);
        $this->client = new Client([
            'headers' => [
                'Authorization' => 'Bearer '.$token
            ],
            'json' => $jsonParams
        ]);
        //dd($this->client);
    }

    //Obtiene lista de valores con Y o N según idioma
    public function getListYesNot()
    {
        return ['Y' => trans('general.Y'), 'N' => trans('general.N')];
    }

    public function getStatusList($status_type_id)
    {
        // Inicializa objeto para servicio back
        $jsonParams = ['status_type_id' => $status_type_id];
        $this->initService($jsonParams);
        $this->url = env('API_ENDPOINT_UTILS').'getStatusList';
        try {
            $response = $this->client->post($this->url);
            $body = $response->getBody()->getContents();
            $data = json_decode($body, true);
            $array = [];
            foreach ($data as $elemento) {
                $array[$elemento['id']] = $elemento['name_'];
            }
            return $array;
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();

                // Procesar la respuesta con error si es necesario
                $data = $response->getBody()->getContents();

                MessageMgr::setMessageResponse(MessageMgr::getTypeError(), 5, $this->url);
                return null;
            }
        }
    }

}
