<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

//http://localhost:8080/api/
$routes->group('api', ['namespace' => 'App\Controllers\API'], function($routes) {
    // ruta : http://localhost:8080/api/users 
    // retorna todos los usuarios
    $routes->get('users', 'Users::index');

    // ruta : http://localhost:8080/api/users/create 
    // espera un json con los datos role, name, nick, pass
    // retorna el usuario creado
    $routes->post('users/create', 'Users::create');

    // ruta : http://localhost:8080/api/users/edit/[id]
    // espera un id en la ruta 
    // retorna el usuario del id pasado
    $routes->get('users/edit/(:num)', 'Users::edit/$1');

    // ruta : http://localhost:8080/api/users/update/[id]
    // espera un id en la ruta y un json con los datos role, name, nick, pass
    // retorna el usuario actualizado
    $routes->put('users/update/(:num)','Users::update/$1');

    // ruta : http://localhost:8080/api/users/delete/[id]
    // espera un id en la ruta
    // retorna el usuario eliminado
    $routes->delete('users/delete/(:num)','Users::delete/$1');

    // ruta : http://localhost:8080/api/users/login
    // espera un id en la ruta y un json con los datos nick y pass
    // retorna el usuario y abre session??
    $routes->post('users/login','Users::login');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
