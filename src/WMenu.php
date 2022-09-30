<?php

namespace SoeurngSar\MenuBuilder;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use SoeurngSar\MenuBuilder\app\Models\Menus;
use SoeurngSar\MenuBuilder\app\Models\MenuItems;

class WMenu
{
    public function render()
    {
        $menu = new Menus();
        $menuItems = new MenuItems();
        $menuList = $menu->select(['id', 'name'])->get();
        $menuList = $menuList->pluck('name', 'id')->prepend('Select menu', 0)->all();

        if ((request()->has("action") && empty(request()->input("menu"))) || request()->input("menu") == '0') {
            return view('wmenu::menu-html')->with("menulist", $menuList);
        } else {
            $menu = Menus::find(request()->get("menu"));
            $menus = $menuItems->getall(request()->input("menu"));

            $data = ['menus' => $menus, 'indmenu' => $menu, 'menulist' => $menuList];

            return view('wmenu::menu-html', $data);
        }
    }

    public function scripts()
    {
        return view('wmenu::scripts');
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function select($name = "menu", $menuList = array(), $cssClass="form-control") : string
    {
        $html = '<select name="' . $name . '" class="'.$cssClass.'" id="menu-dropdown">';
        $html .= '<option value="0">' . trans('wmenu::menu.select'). '...</option>';

        foreach ($menuList as $key => $menu) {
            $selected = '';

            if ((int)request()->get('menu') === $menu->id) {
                $selected = 'selected="selected"';
            }

            $html .= '<option ' . $selected . ' value="' . $menu->id . '">' . $menu->name . '</option>';
        }

        $html .= '</select>';

        return $html;
    }

    public static function renderBootstrapNav($brand = 'Brand', $menuName = 'Primary', $nav_type = 'navbar-default') : string
    {
      $menu = self::getByName($menuName);

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

    public static function getByName($name) : array
    {
        $menuId = optional(Menus::byName($name))->id;
        return self::get($menuId);
    }

    public static function get($menuId) : array
    {
        $menuItem = new MenuItems;
        $menuList = $menuItem->getall($menuId);
        $roots = $menuList->where('menu', $menuId)->where('parent', '0');

        return self::tree($roots, $menuList);
    }

    private static function tree($items, $allItems) : array
    {
        $data = array();
        $i = 0;

        foreach ($items as $item) {
            $data[$i] = $item->toArray();
            $find = $allItems->where('parent', $item->id);
            $data[$i]['child'] = array();

            if ($find->count()) {
                $data[$i]['child'] = self::tree($find, $allItems);
            }

            $i++;
        }

        return $data;
    }
}
