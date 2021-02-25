<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//$route['qr/(:any)'] = 'mpv/qr/$1';
$route['panel'] = 'welcome/panel';
$route['default_controller'] = 'Auth';
$route['categorias'] = 'categorias';
$route['clientes/(:any)'] = 'clientes/$1';
$route['productos'] = 'productos';
$route['translate_uri_dashes'] = FALSE;
$route['404_override'] = 'sacppv/error404';




