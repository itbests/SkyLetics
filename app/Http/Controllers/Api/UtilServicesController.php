<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Status;
use Illuminate\Support\Facades\DB;

class UtilServicesController extends Controller
{

    public function getStatusList(Request $request)
    {
        $json = $request->json()->all();
        $status = Status::select(
                            'status.id',
                            'status.name_'
                        )->where('status.status_type_id', '=', $json['status_type_id'])
                        ->get();
        return $status;
    }

}
