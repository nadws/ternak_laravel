<?php

namespace App\Http\Controllers;

use App\Models\Menusidebar;
use App\Models\SubMenusidebar;
use Illuminate\Http\Request;

class AksesConttroller extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'title' => 'Menu Sidebar',
            'menu' => Menusidebar::all(),
            'sub_menu' => SubMenusidebar::join('tb_menu', 'tb_menu.id_menu', '=', 'tb_sub_menu.id_menu')->get(),
            'logout' => $request->session()->get('logout'),
        ];

        return view('menu_sidebar/index', $data);
    }

    public function save_sub_menu(Request $request)
    {
        $data = [
            'id_menu' => $request->id_menu,
            'sub_menu' => $request->sub_menu,
            'url' => $request->url,
        ];
        SubMenusidebar::create($data);
        return redirect()->route("sidebar")->with('sukses', 'Sukses');
    }
    public function save_menu(Request $request)
    {
        $data = [
            'menu' => $request->menu,
            'icon' => $request->icon
        ];
        Menusidebar::create($data);
        return redirect()->route("sidebar")->with('sukses', 'Sukses');
    }

    public function save_urutan(Request $r)
    {

        $id_menu = $r->id_menu;
        $urutan = $r->urutan;

        for ($count = 0; $count < count($id_menu); $count++) {
            $data = [
                'urutan' => $urutan[$count]
            ];
            Menusidebar::where('id_menu', $id_menu[$count])->update($data);
        }
        return redirect()->route("sidebar")->with('sukses', 'Sukses');
    }
}
