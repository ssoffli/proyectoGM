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
    // con session abierta rol admin retorna todos los usuarios
    $routes->get('users', 'Users::index');

    // ruta : http://localhost:8080/api/users/create 
    // espera un json con los datos role, name, nick, pass
    // con session abierta rol admin retorna el usuario creado
    $routes->post('users/create', 'Users::create');

    // ruta : http://localhost:8080/api/users/edit/[id]
    // espera un id en la ruta 
    // con session abierta rol admin retorna el usuario del id pasado
    $routes->get('users/edit/(:num)', 'Users::edit/$1');

    // ruta : http://localhost:8080/api/users/update/[id]
    // espera un id en la ruta y un json con los datos [role = {'admin', 'dependencia', 'jefatura'}, 
    //                                                   name, nick, pass]
    // con session abierta rol admin retorna el usuario actualizado
    $routes->put('users/update/(:num)','Users::update/$1');

    // ruta : http://localhost:8080/api/users/delete/[id]
    // espera un id en la ruta
    // con session abierta rol admin retorna el usuario eliminado
    $routes->delete('users/delete/(:num)','Users::delete/$1');

    // ruta : http://localhost:8080/api/users/login
    // espera json con los datos nick y pass
    // retorna el id, rol, name  y abre session
    $routes->post('users/login','Users::login');

    // ruta : http://localhost:8080/api/users/logout
    // cierra la session
    $routes->get('users/logout','Users::logout');

    // ruta : http://localhost:8080/api/orders
    // con session abierta rol dependencia o jefatura retorna lista de ordenes
    $routes->get('orders', 'Orders::index');

    // ruta : http://localhost:8080/api/orders/create
    // espera un form-data con los datos:
    //  type = { 'od' , 'og', 'or'}  ordern dia , orden guarnicion, orden reservada
    //  number que es numero de orden
    //  year año de la orden
    //  date fecha
    //  about descripcion sobre la orden
    //  file  archivo pdf max 10mb
    // con session abierta rol jefatura retorna la orden creada
    $routes->post('orders/create', 'Orders::create');

    // ruta : http://localhost:8080/api/orders/delete/[id]
    // espera un id en la ruta
    // con session abierta rol jefatura retorna la orden eliminada
    $routes->delete('orders/delete/(:num)','Orders::delete/$1');
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
