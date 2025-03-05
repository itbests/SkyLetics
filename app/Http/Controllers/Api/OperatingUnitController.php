<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Status;
use App\Models\OperatingUnit;
use Illuminate\Support\Facades\DB;

class OperatingUnitController extends Controller
{
    protected $redirectTo = 'app/operatingUnit';

    protected $rules =
    [
        'name_' => 'required|string|max:200',
        'description' => 'required|string|max:2000'
    ];

    public function index()
    {
        $status = Status::comboBox();
        $infoMenu = Menu::getInfoMenu('app/operatingUnit');

        $operatingUnit = OperatingUnit::join('status','status.id', '=', 'operating_unit.status_id')
                        ->select(
                            'operating_unit.id',
                            'operating_unit.name_',
                            'operating_unit.address',
                            'operating_unit.office_id',
                            'operating_unit.phone1',
                            'operating_unit.phone2',
                            'operating_unit.email',
                            'operating_unit.view_line_process',
                            'operating_unit.autoassigned',
                            'operating_unit.register_date',
                            'status.name_ as status_id'
                        )->get();
        return $operatingUnit;
    }

    public function show(Request $request)
    {
        $json = $request->json()->all();
        $operatingUnit = OperatingUnit::join('status','status.id', '=', 'operating_unit.status_id')
                        ->select(
                            'operating_unit.id',
                            'operating_unit.name_',
                            'operating_unit.address',
                            'operating_unit.office_id',
                            'operating_unit.phone1',
                            'operating_unit.phone2',
                            'operating_unit.email',
                            DB::raw("CASE
                                WHEN operating_unit.view_line_process = 'Y' THEN '".trans('general.Y')."'
                                WHEN operating_unit.view_line_process = 'N' THEN '".trans('general.N')."'
                                ELSE operating_unit.view_line_process
                                END AS view_line_process"
                            ),
                            DB::raw("CASE
                                WHEN operating_unit.autoassigned = 'Y' THEN '".trans('general.Y')."'
                                WHEN operating_unit.autoassigned = 'N' THEN '".trans('general.N')."'
                                ELSE operating_unit.autoassigned
                                END AS autoassigned"
                            ),
                            'operating_unit.register_date',
                            'status.name_ as status_id'
                        )
                        ->where('operating_unit.id', '=', $json['id'])
                        ->get();
        return $operatingUnit;
    }

    public function edit(Request $request)
    {
        $json = $request->json()->all();
        $operatingUnit = OperatingUnit::findOrFail($json['id']);
        return $operatingUnit;
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
