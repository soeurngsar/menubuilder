<?php

return [
	/* you can add your own middleware here */

	'middleware' => ['web','admin'],

	/* you can set your own table prefix here */
	'table_prefix' => '',

    /* you can set your own table names */
    'table_name_menus' => 'menus',

    'table_name_items' => 'menu_items',

    /* you can set your route path*/
    'route_path' => isset($_SERVER['REQUEST_URI']) ? explode('/', $_SERVER['REQUEST_URI'])[1].'/admin' : '/admin',

		'domain' => 'http://localhost:8000/',
];
