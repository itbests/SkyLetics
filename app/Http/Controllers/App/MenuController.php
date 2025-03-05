<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProfileMenu;
use App\Utilities\ParameterMgr;

class MenuController extends Controller
{
    public function optionsMenu($profile, $parent)
    {
        return ProfileMenu::join('menu','profile_menu.menu_id', '=', 'menu.id')
            ->where('profile_menu.profile_id', '=', $profile)
            ->where('profile_menu.status_id', '=', ParameterMgr::getParameterValue('ACTIVE_STATUS'))
            ->where('menu.menu_type_id', '<', ParameterMgr::getParameterValue('ELEMENT_MENU_TYPE'))
            ->orderBy('menu.id')
            ->get()
            ->toArray();
    }

    public function getChildren($data, $line)
    {
        $children = [];
        foreach ($data as $line1) {
            if ($line['id'] == $line1['menu_dad_id']) {
                $children = array_merge($children, [ array_merge($line1, ['submenu' => $this->getChildren($data, $line1) ]) ]);
            }
        }
        return $children;
    }
}
