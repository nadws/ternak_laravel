<?php

namespace App\Http\Controllers;

use App\Models\Menusidebar;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class User extends Controller
{
    public function index(Request $r)
    {
        $data = [
            'title' => 'Data User',
            'user' => DB::select("SELECT *
            FROM users AS a
            LEFT JOIN tb_role AS b ON b.id_role = a.role_id"),
        ];
        return view('user.index', $data);
    }

    public function permission(Request $r)
    {
        $id_user = $r->id;
        $data = [
            'title' => 'Data User',
            'menu' => Menusidebar::all(),
            'id_user' => $id_user,
            'logout' => $r->session()->get('logout'),
        ];

        return view('user/permission', $data);
    }

    public function updatepermission(Request $r)
    {
        $id_user = $r->kd_user;
        $permission =  $r->permission;


        Permission::where('id_user', $id_user)->delete();

        for ($i = 0; $i < count($r->permission); $i++) {
            $data_permission = [
                'id_user' => $id_user,
                'permission' => $permission[$i]
            ];

            // var_dump($id_user);
            Permission::create($data_permission);
        }
        return redirect()->route('user')->with('sukses', 'Sukses');
    }
}
