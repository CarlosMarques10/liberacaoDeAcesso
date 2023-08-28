<?php
use core\Router;

$router = new Router();

$router->get('/', 'HomeController@index');

$router->get('/login', 'LoginController@login');
$router->post('/loginAction', 'LoginController@loginAction');

$router->get('/register', 'LoginController@register');
$router->post('/registerAction', 'LoginController@registerAction');

$router->get('/addAccessProhibited', 'HomeController@addAccessProhibited');
$router->post('/addAccessProhibitedAction', 'HomeController@addAccessProhibitedAction');

$router->get('/addAccessExit', 'HomeController@addAccessExit');
$router->post('/addAccessExitAction', 'HomeController@addAccessExitAction');

$router->get('/sair', 'LoginController@sair');