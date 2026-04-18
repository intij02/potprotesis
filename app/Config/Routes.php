<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/servicios', 'Pages::servicios');
$routes->get('/galeria', 'Pages::galeria');
$routes->get('/contacto', 'Pages::contacto');
$routes->match(['get', 'post'], '/orden-laboratorio', 'Orders::create');
$routes->get('/privacidad', 'Pages::privacidad');
$routes->get('/terminos', 'Pages::terminos');

$routes->group('admin', static function ($routes) {
    $routes->get('login', 'Admin\Auth::login');
    $routes->post('login', 'Admin\Auth::attempt');
    $routes->get('logout', 'Admin\Auth::logout');
    $routes->get('ordenes', 'Admin\Orders::index');
    $routes->get('ordenes/editar/(:num)', 'Admin\Orders::edit/$1');
    $routes->post('ordenes/actualizar/(:num)', 'Admin\Orders::update/$1');
    $routes->get('usuarios', 'Admin\Users::index');
    $routes->get('usuarios/nuevo', 'Admin\Users::create');
    $routes->post('usuarios/guardar', 'Admin\Users::store');
    $routes->get('usuarios/editar/(:num)', 'Admin\Users::edit/$1');
    $routes->post('usuarios/actualizar/(:num)', 'Admin\Users::update/$1');
    $routes->post('usuarios/eliminar/(:num)', 'Admin\Users::delete/$1');
});
