# Laravel Drag and Drop menu editor like wordpress

forked from https://github.com/lordmacu/wmenu
![Laravel drag and drop menu for backpack](screenshot/menubuilder.png?raw=true)
### Note
**This package is work perfectly with Backpack and require minimum version of 4.0**
### Installation
1. Run
```php
composer require soeurngsar/menubuilder
```
2. Run publish assets
```php
php artisan vendor:publish --provider="SoeurngSar\MenuBuilder\MenuServiceProvider"
```
3. Configure (optional) in ***config/menu.php*** :
- ***CUSTOM MIDDLEWARE:*** You can add you own middleware
- ***TABLE PREFIX:*** By default this package will create 2 new tables named "menus" and "menu_items" but you can still add your own table prefix avoiding conflict with existing table
- ***TABLE NAMES*** If you want use specific name of tables you have to modify that and the migrations
- ***Custom routes*** If you want to edit the route path you can edit the field
4. Run migrate

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
In this example, you must have a menu named  *Primary*

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


### Credits

 * [wmenu](https://github.com/lordmacu/wmenu) laravel package menu like wordpress

### Compatibility
* Tested with laravel 8.0 with Backpack version 4.0
