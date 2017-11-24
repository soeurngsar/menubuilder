<?php

namespace SoeurngSar\MenuBuilder\app\Models;

use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{
    protected $table = 'menus';

    public function __construct( array $attributes = [] ){
    	$this->table = config('menu.table_prefix') . config('menu.table_name_menus');
    }

    public static function byName($name)
    {
        return self::where('name', '=', $name)->first();
    }

}
