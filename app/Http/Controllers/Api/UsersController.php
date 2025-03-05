<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Status;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Utilities\MessageMgr;

class UsersController extends Controller
{
    protected $redirectTo = 'app/users';

    protected $rules =
    [
        'name_' => 'required|string|max:200',
        'description' => 'required|string|max:2000'
    ];

    public function index()
    {
        $status = Status::comboBox();
    }

    public function show(Request $request)
    {

    }

    public function edit(Request $request)
    {

    }

    public function changePassword(Request $request)
    {
        try {
            DB::beginTransaction();

            $json = $request->json()->all();

            $userId = $json['isbUserId'];
            $oldPassword = $json['isbOldPassword'];
            $newPassword = $json['isbNewPassword'];
            $confirmPassword = $json['isbConfirmPassword'];

            $users = User::find($userId);
            $hashedPassword = $users['password'];

            if (!Hash::check($oldPassword, $hashedPassword)) {
                return MessageMgr::getMessage(7);
            }

            if ($newPassword != $confirmPassword) {
                return MessageMgr::getMessage(8);
            }

            //Realiza cambio de contraseña
            $users->password = Hash::make($newPassword);
            $users->save();

            DB::commit();

            return MessageMgr::getMessage(9);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
            return MessageMgr::getMessage(5, $e);
        }
    }

}
