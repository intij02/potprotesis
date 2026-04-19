<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/servicios', 'Pages::servicios');
$routes->get('/galeria', 'Pages::galeria');
$routes->match(['get', 'post'], '/contacto', 'Pages::contacto');
$routes->match(['get', 'post'], '/orden-laboratorio', 'Orders::create');
$routes->post('/orden-laboratorio/paciente', 'Orders::storePatient');
$routes->get('/cliente/login', 'Client\Auth::login');
$routes->post('/cliente/login', 'Client\Auth::attempt');
$routes->get('/cliente/registro', 'Client\Auth::register');
$routes->post('/cliente/registro', 'Client\Auth::store');
$routes->get('/cliente/activar', 'Client\Auth::activate');
$routes->get('/cliente/logout', 'Client\Auth::logout');
$routes->get('/cliente/panel', 'Client\Panel::index');
$routes->get('/cliente/pacientes', 'Client\Patients::index');
$routes->get('/cliente/pacientes/nuevo', 'Client\Patients::create');
$routes->post('/cliente/pacientes/guardar', 'Client\Patients::store');
$routes->get('/cliente/pacientes/editar/(:num)', 'Client\Patients::edit/$1');
$routes->post('/cliente/pacientes/actualizar/(:num)', 'Client\Patients::update/$1');
$routes->post('/cliente/pacientes/eliminar/(:num)', 'Client\Patients::delete/$1');
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
    $routes->get('clientes', 'Admin\Clients::index');
    $routes->get('clientes/nuevo', 'Admin\Clients::create');
    $routes->post('clientes/guardar', 'Admin\Clients::store');
    $routes->get('clientes/editar/(:num)', 'Admin\Clients::edit/$1');
    $routes->post('clientes/actualizar/(:num)', 'Admin\Clients::update/$1');
    $routes->post('clientes/eliminar/(:num)', 'Admin\Clients::delete/$1');
    $routes->get('pacientes', 'Admin\Patients::index');
    $routes->get('pacientes/nuevo', 'Admin\Patients::create');
    $routes->post('pacientes/guardar', 'Admin\Patients::store');
    $routes->get('pacientes/editar/(:num)', 'Admin\Patients::edit/$1');
    $routes->post('pacientes/actualizar/(:num)', 'Admin\Patients::update/$1');
    $routes->post('pacientes/eliminar/(:num)', 'Admin\Patients::delete/$1');
    $routes->get('servicios', 'Admin\Services::index');
    $routes->get('servicios/nuevo', 'Admin\Services::create');
    $routes->post('servicios/guardar', 'Admin\Services::store');
    $routes->get('servicios/editar/(:num)', 'Admin\Services::edit/$1');
    $routes->post('servicios/actualizar/(:num)', 'Admin\Services::update/$1');
    $routes->post('servicios/eliminar/(:num)', 'Admin\Services::delete/$1');
    $routes->get('galeria', 'Admin\Gallery::index');
    $routes->get('galeria/nuevo', 'Admin\Gallery::create');
    $routes->post('galeria/guardar', 'Admin\Gallery::store');
    $routes->get('galeria/editar/(:num)', 'Admin\Gallery::edit/$1');
    $routes->post('galeria/actualizar/(:num)', 'Admin\Gallery::update/$1');
    $routes->post('galeria/eliminar/(:num)', 'Admin\Gallery::delete/$1');
    $routes->get('configuracion', 'Admin\Settings::edit');
    $routes->post('configuracion', 'Admin\Settings::update');
    $routes->get('mensajes-contacto', 'Admin\ContactMessages::index');
    $routes->post('mensajes-contacto/marcar-leido/(:num)', 'Admin\ContactMessages::markRead/$1');
});
