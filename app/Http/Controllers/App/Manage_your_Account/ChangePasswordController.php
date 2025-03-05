<?php

namespace App\Http\Controllers\App\Manage_your_Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

use App\Models\Menu;
use App\Utilities\MessageMgr;
use App\Utilities\UtilServicesMgr;

class ChangePasswordController extends Controller
{
    private static $db = 'user_session';
    protected $redirectTo = 'home';
    private $client;
    private $url;
    private $sessionTokenMenu = "name_";
    private $sessionValueMenu = "Change_of_password";

    private $rules =
    [
        'isbOldPassword' => 'required|string|max:255',
        'isbNewPassword' => 'required|string|max:255',
        'isbConfirmPassword' => 'required|string|max:255',
        'isbCaptcha' => 'required|string|max:6',
    ];

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
        try {
            $infoMenu = [];
            $menu = new Menu;

            $dataMenu = $menu->searchValueInArray(session('menuUser'), $this->sessionTokenMenu, $this->sessionValueMenu);
            $infoMenu = $menu->getInfoMenu($dataMenu['link_command']);

            return view('app.manage_your_account.change_password',['infoMenu' => $infoMenu]);

        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();

                // Procesar la respuesta con error si es necesario
                $data = $response->getBody()->getContents();

                MessageMgr::setMessageResponse(MessageMgr::getTypeError(), 5, $this->url);
                return PersonController::index();
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
                return PersonController::index();
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
                return PersonController::index();
            }
        }
    }

    public function save(Request $request)
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
            //return PersonController::index();
        }

        // Inicializa objeto para servicio back
        $jsonParams = [
            'form_params' => [
                'isbUserId' => 1,
                'isbOldPassword' => '9486047611',
                'isbNewPassword' => '94860476',
                'isbConfirmPassword' => '94860476',
            ]
        ];
        $this->initService($jsonParams);
        $this->url = env('API_ENDPOINT').'users.changePassword';
        try {
            $response = $this->client->post($this->url, $jsonParams);

            $body = $response->getBody()->getContents();
            $data = json_decode($body, true);
            dd($data);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                //dd($response);
                // Procesar la respuesta con error si es necesario
                $statusCode = $response->getStatusCode();
                $data = $response->getBody()->getContents();

                MessageMgr::setMessageResponse(MessageMgr::getTypeError(), 5, $this->url);
                //return HomeController::dashboard();
            }
        }

        //dd($request->all());
    }

    public function destroy($id)
    {

    }

}
