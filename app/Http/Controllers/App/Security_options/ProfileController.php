<?php

namespace App\Http\Controllers\App\Security_options;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Http\Controllers\App\HomeController;

use App\Models\Menu;
use App\Utilities\MessageMgr;
use App\Utilities\UtilServicesMgr;

class ProfileController extends Controller
{
    private static $db = 'user_session';
    protected $redirectTo = 'app/profile';
    private $client;
    private $url;

    protected $rules =
    [
        'name_' => 'required|string|max:200',
        'description' => 'required|string|max:2000'
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
        // Inicializa objeto para servicio back
        $jsonParams = [];
        $this->initService($jsonParams);
        $this->url = env('API_ENDPOINT').'profile';
        try {
            $response = $this->client->post($this->url);
            $body = $response->getBody()->getContents();
            $data = json_decode($body, true);
            $infoMenu = Menu::getInfoMenu('app/profile');
            $utilServices = new UtilServicesMgr();
            return view('app.security_options.profile.index', ['profile' => $data, 'infoMenu' => $infoMenu, 'utilServices' => $utilServices]);
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
        $this->url = env('API_ENDPOINT').'profile.show';
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
                return HomeController::dashboard();
            }
        }
    }

    public function edit($id)
    {
        // Inicializa objeto para servicio back
        $jsonParams = ['id' => $id];
        $this->initService($jsonParams);
        $this->url = env('API_ENDPOINT').'profile.edit';
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
                return HomeController::dashboard();
            }
        }
    }

    public function listsDependence($company_id, $parent)
    {

    }

    public function getChildren($data, $line)
    {

    }

    public function destroy($id)
    {

    }

}
