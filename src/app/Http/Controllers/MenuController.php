<?php

namespace SoeurngSar\MenuBuilder\app\Http\Controllers;

use Illuminate\Support\Facades\Route;
use SoeurngSar\MenuBuilder\app\Facades\Menu;
use App\Http\Controllers\Controller;
use SoeurngSar\MenuBuilder\app\Models\Menus;
use SoeurngSar\MenuBuilder\app\Models\MenuItems;

class MenuController extends Controller
{

    public function index(){

        $menuList = Menu::getAllMenu();
        $routes = Route::getRoutes()->get('GET');
        $routesList = array_filter($routes, function ($route) {
            return strpos($route->uri, 'admin') !== 0;
        });

        if(request()->has('menu')){
          return view('wmenu::menu-html',[
            'menulist' => $menuList,
            'menus' => MenuItems::where('menu', request()->get('menu'))->orderBy('sort')->get(),
            'indmenu' => Menus::find(request()->get('menu')),
            'routes' => $routesList,
          ]);
        }else{
          return view('wmenu::menu-html',[
            'menulist' => $menuList,
          ]);
        }

    }

    public function createnewmenu()
    {
        $menu = new Menus();
        $menu->name = request()->input("menuname");
        $menu->save();
        return response()->json(array("resp" => $menu->id));
    }

    public function deleteitemmenu()
    {
        $menuitem = MenuItems::find(request()->input("id"));

        $menuitem->delete();
    }

    public function deletemenug()
    {
        $menus = new MenuItems();
        $getall = $menus->getall(request()->input("id"));
        if (count($getall) == 0) {
            $menudelete = Menus::find(request()->input("id"));
            $menudelete->delete();

            return response()->json(array("resp" => "you delete this item"));
        } else {
            return response()->json(array("resp" => "You have to delete all items first", "error" => 1));

        }
    }

    public function updateitem()
    {
        $arraydata = request()->input("arraydata");
        if (is_array($arraydata)) {
            foreach ($arraydata as $value) {
                $menuitem = MenuItems::find($value['id']);
                $menuitem->label = $value['label'];
                $menuitem->link = $value['link'];
                $menuitem->class = $value['class'];
                $menuitem->save();
            }
        } else {
            $menuitem = MenuItems::find(request()->input("id"));
            $menuitem->label = request()->input("label");
            $menuitem->link = request()->input("url");
            $menuitem->class = request()->input("clases");
            $menuitem->save();
        }
    }

    public function addcustommenu()
    {

        $menuitem = new MenuItems();
        $menuitem->label = request()->input("labelmenu");
        $menuitem->link = request()->input("linkmenu");
        $menuitem->menu = request()->input("idmenu");
        $menuitem->sort = MenuItems::getNextSortRoot(request()->input("idmenu"));
        $menuitem->save();

    }

    public function generatemenucontrol()
    {
        $menu = Menus::find(request()->input("idmenu"));
        $menu->name = request()->input("menuname");
        $menu->save();
        if (is_array(request()->input("arraydata"))) {
            foreach (request()->input("arraydata") as $value) {
                $menuitem = MenuItems::find($value["id"]);
                $menuitem->parent = $value["parent"];
                $menuitem->sort = $value["sort"];
                $menuitem->depth = $value["depth"];
                $menuitem->save();
            }
        }
        echo response()->json(array("resp" => 1));
    }
}
