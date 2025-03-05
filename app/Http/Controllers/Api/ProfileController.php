<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Status;
use App\Models\Profile;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    protected $redirectTo = 'app/profile';

    protected $rules =
    [
        'name_' => 'required|string|max:200',
        'description' => 'required|string|max:2000'
    ];

    public function index()
    {
        $status = Status::comboBox();
        $infoMenu = Menu::getInfoMenu('app/profile');

        $profile = Profile::join('status','status.id', '=', 'profile.status_id')
                        ->select(
                            'profile.id',
                            'profile.name_',
                            'profile.register_date',
                            'profile.observation',
                            'status.name_ as status_id'
                        )->get();
        return $profile;
    }

    public function show(Request $request)
    {
        $json = $request->json()->all();
        $profile = Profile::join('status','status.id', '=', 'operating_unit.status_id')
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
        return $profile;
    }

    public function edit(Request $request)
    {
        $json = $request->json()->all();
        $profile = Profile::findOrFail($json['id']);
        return $profile;
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
