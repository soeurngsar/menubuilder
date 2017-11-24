# Laravel Drag and Drop menu editor like wordpress

forked from https://github.com/lordmacu/wmenu
![Laravel drag and drop menu for backpack](screenshot/menubuilder.png?raw=true)
### Note
**This package is work perfectly with Backpack only**
### Installation
1. Run
```php
composer require soeurngsar/menubuilder
```
***Step 2 & 3 are optional if you are using laravel 5.5***

2. Add the following class, to "providers" array in the file config/app.php (optional on laravel 5.5)
```php
SoeurngSar\MenuBuilder\MenuServiceProvider::class,
```
3. add facade in the file config/app.php (optional on laravel 5.5)
```php
'Menu' => SoeurngSar\MenuBuilder\app\Facades\Menu::class,
```
4. Run publish
```php
php artisan vendor:publish --provider="SoeurngSar\MenuBuilder\MenuServiceProvider"
```
5. Configure (optional) in ***config/menu.php*** :
- ***CUSTOM MIDDLEWARE:*** You can add you own middleware
- ***TABLE PREFIX:*** By default this package will create 2 new tables named "menus" and "menu_items" but you can still add your own table prefix avoiding conflict with existing table
- ***TABLE NAMES*** If you want use specific name of tables you have to modify that and the migrations
- ***Custom routes*** If you want to edit the route path you can edit the field
6. Run migrate

 ```php
 php artisan migrate
 ```

 DONE


### Usage Example
On your view blade file for admin
```php

@section('contents')
    {!! Menu::render() !!}
@endsection

```

On your view blade file for frontend
```php

@section('contents')
    {!! Menu::renderBootstrapNav('Brand Text','menu name','navbar-default') !!}
@endsection

```

### Get Menu Items By Menu ID
```php
use SoeurngSar\MenuBuilder\app\Facades\Menu;
...
/*
Parameter: Menu ID
Return: Array
*/
$menuList = Menu::get(1);
```

### Get Menu Items By Menu Name
In this example, you must have a menu named  *Admin*

```php
use SoeurngSar\MenuBuilder\app\Facades\Menu;
...
/*
Parameter: Menu ID
Return: Array
*/
$menuList = Menu::getByName('Primary');
```

### Using The Model
Call the model class
```php
use SoeurngSar\MenuBuilder\app\Models\Menus;
use SoeurngSar\MenuBuilder\app\Models\MenuItems;
```

### Customization
you can edit the menu interface in ***resources/views/vendor/backpack/menu-builder/menu-html.blade.php***

### Credits

 * [wmenu](https://github.com/lordmacu/wmenu) laravel package menu like wordpress

### Compability
* Tested with laravel 5.2, 5.3, 5.4, 5.5
