<?php

namespace App\Http\Controllers\App\Parameterization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Http\Controllers\App\HomeController;

use App\Models\Menu;
use App\Utilities\MessageMgr;
use App\Utilities\UtilServicesMgr;
use OperatingUnit;

class OperatingUnitController extends Controller
{
    private static $db = 'user_session';
    protected $redirectTo = 'app/operatingUnit';
    private $client;
    private $url;

    private $rules =
    [
        'name_' => 'required|string|max:255',
        'name_' => 'required|string|max:255',
        'office_id' => 'required|string|max:255',
        'phone1' => 'required|string|max:255',
        'email' => 'required|email',
        'view_line_process' => 'required|in:Y,N',
        'autoassigned' => 'required|in:Y,N',
        'status_id' => 'required|integer',
    ];

    /*
    Errores personalizados solo para el controlador
    protected $messages = [
        'name_.required' => trans('operating_unit.error_name_'),
    ];
    */

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

    public function index()
    {
        // Inicializa objeto para servicio back
        $jsonParams = [];
        $this->initService($jsonParams);
        $this->url = env('API_ENDPOINT').'operatingUnit';
        try {
            $response = $this->client->post($this->url);
            $body = $response->getBody()->getContents();
            $data = json_decode($body, true);
            $infoMenu = Menu::getInfoMenu('app/operatingUnit');
            $utilServices = new UtilServicesMgr();
            return view('app.parameterization.operatingUnit.index', ['operatingUnit' => $data, 'infoMenu' => $infoMenu, 'utilServices' => $utilServices]);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                //dd($response);
                // Procesar la respuesta con error si es necesario
                $statusCode = $response->getStatusCode();
                $data = $response->getBody()->getContents();

                MessageMgr::setMessageResponse(MessageMgr::getTypeError(), 5, $this->url);
                return HomeController::dashboard();
            }
        }
    }

    public function show($id)
    {
        // Inicializa objeto para servicio back
        $jsonParams = ['id' => $id];
        $this->initService($jsonParams);
        $this->url = env('API_ENDPOINT').'operatingUnit.show';
        try {
            $response = $this->client->post($this->url);
            $body = $response->getBody()->getContents();
            $data = json_decode($body, true);
            return $data;
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();

                // Procesar la respuesta con error si es necesario
                $data = $response->getBody()->getContents();

                MessageMgr::setMessageResponse(MessageMgr::getTypeError(), 5, $this->url);
                return OperatingUnitController::index();
            }
        }
    }

    public function edit($id)
    {
        // Inicializa objeto para servicio back
        $jsonParams = ['id' => $id];
        $this->initService($jsonParams);
        $this->url = env('API_ENDPOINT').'operatingUnit.edit';
        try {
            $response = $this->client->post($this->url);
            $body = $response->getBody()->getContents();
            $data = json_decode($body, true);
            return $data;
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();

                // Procesar la respuesta con error si es necesario
                $data = $response->getBody()->getContents();

                MessageMgr::setMessageResponse(MessageMgr::getTypeError(), 5, $this->url);
                return OperatingUnitController::index();
            }
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules);
        if ($validator->fails()) {
            // Recopila todos los errores de validación
            $errors = $validator->errors()->all();

            // Convierte los errores en una cadena de texto
            $errorMessages = implode("<br>", $errors);
            dd($errorMessages);
            // Envia los mensajes de error a la vista
            MessageMgr::setMessageResponse(MessageMgr::getTypeError(), 1, $errorMessages);
            //return OperatingUnitController::index();
        }
        MessageMgr::setMessageResponse(MessageMgr::getTypeError(), 5, $this->url);
        return OperatingUnitController::index();
    }

    public function destroy($id)
    {

    }

}
