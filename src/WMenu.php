<?php

namespace SoeurngSar\MenuBuilder;

use App\Http\Requests;
use SoeurngSar\MenuBuilder\app\Models\Menus;
use SoeurngSar\MenuBuilder\app\Models\MenuItems;

class WMenu
{

    public function render()
    {
        $menu = new Menus();
        $menuitems = new MenuItems();
        $menulist = $menu->select(['id', 'name'])->get();
        $menulist = $menulist->pluck('name', 'id')->prepend('Select menu', 0)->all();

        if ((request()->has("action") && empty(request()->input("menu"))) || request()->input("menu") == '0') {
            return view('vendor.sarmenu.menu-html')->with("menulist", $menulist);
        } else {

            $menu = Menus::find(request()->input("menu"));
            $menus = $menuitems->getall(request()->input("menu"));

            $data = ['menus' => $menus, 'indmenu' => $menu, 'menulist' => $menulist];
            return view('vendor.sarmenu.menu-html', $data);
        }

    }

    public function scripts()
    {
        return view('vendor.sarmenu.scripts');
    }

    public function select($name = "menu", $menulist = array(), $cssClass="form-control")
    {
        $html = '<select name="' . $name . '" class="'.$cssClass.'" id="menu-dropdown">';

        foreach ($menulist as $key => $val) {
            $active = '';
            if (request()->input('menu') == $val->id) {
                $active = 'selected="selected"';
            }
            $html .= '<option ' . $active . ' value="' . $val->id . '">' . $val->name . '</option>';
        }
        $html .= '</select>';
        return $html;
    }

    public static function renderBootstrapNav($brand = 'Brand', $menu_name, $nav_type = 'navbar-default'){
      $menu = self::getByName($menu_name);

      $nav =  '<nav class="navbar '.$nav_type.'">
                <div class="container">
                  <div class="navbar-header">
                    <a class="navbar-brand" href="/">'.$brand.'</a>
                  </div>
                  <ul class="nav navbar-nav">';
                   foreach ($menu as $key => $value) {
                     if(count($value['child']) > 0){
                       $nav .= '<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="'.$value["link"].'">'.$value['label'];
                       $nav .= '<span class="caret"></span></a>';
                       $nav .= '<ul class="dropdown-menu">';
                       foreach ($value['child'] as  $child) {
                         $nav .= '<li><a href="'.$child["link"].'">'.$child['label'].'</a></li>';
                       }
                       $nav .= '</ul>';
                       $nav .= '</li>';
                     }else{
                       $nav .= '<li><a href="'.$value["link"].'">'.$value['label'].'</a></li>';
                     }
                   }
                  $nav .= '</ul>';
                $nav .= '</div>';
               $nav .= '</nav>';
       return $nav;
    }

    public static function getAllMenu() {
      return Menus::all();
    }

    public static function getByName($name)
    {
        $menu_id = optional(Menus::byName($name))->id;
        return self::get($menu_id);
    }

    public static function get($menu_id)
    {
        $menuItem = new MenuItems;
        $menu_list = $menuItem->getall($menu_id);

        $roots = $menu_list->where('menu', $menu_id)->where('parent', '0');

        $items = self::tree($roots, $menu_list);
        return $items;
    }

    private static function tree($items, $all_items)
    {
        $data_arr = array();
        $i = 0;
        foreach ($items as $item) {
            $data_arr[$i] = $item->toArray();
            $find = $all_items->where('parent', $item->id);

            $data_arr[$i]['child'] = array();

            if ($find->count()) {
                $data_arr[$i]['child'] = self::tree($find, $all_items);
            }

            $i++;
        }

        return $data_arr;
    }

}
