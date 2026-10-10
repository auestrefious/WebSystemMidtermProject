<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
$routes->get('/', 'Auth::login');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attempt');
$routes->post('logout', 'Auth::logout');


/*
|--------------------------------------------------------------------------
| Protected Management Routes
|--------------------------------------------------------------------------
*/

$routes->group('', ['filter' => 'auth'], function ($routes) {

    // Dashboard
    $routes->get('dashboard', 'Auth::dashboard');

    // Staff/User Management
    $routes->get('users', 'Users::index');
    $routes->get('users/new', 'Users::new');
    $routes->post('users', 'Users::create');
    $routes->get('users/(:num)/edit', 'Users::edit/$1');
    $routes->post('users/(:num)/update', 'Users::update/$1');
    $routes->post('users/(:num)/delete', 'Users::delete/$1');

    // Customer Management
    $routes->get('customers', 'Customers::index');
    $routes->get('customers/new', 'Customers::add');
    $routes->post('customers', 'Customers::store');
    $routes->get('customers/(:num)/edit', 'Customers::edit/$1');
    $routes->post('customers/(:num)/update', 'Customers::update/$1');
    $routes->post('customers/(:num)/delete', 'Customers::delete/$1');

    // Product Management
    $routes->get('products', 'Products::index');
    $routes->get('products/new', 'Products::add');
    $routes->post('products', 'Products::store');
    $routes->get('products/(:num)/edit', 'Products::edit/$1');
    $routes->post('products/(:num)/update', 'Products::update/$1');
    $routes->post('products/(:num)/archive', 'Products::archive/$1');

    // Sales Management
    $routes->get('sales/record', 'Sales::record');
    $routes->post('sales/store', 'Sales::store');
    $routes->get('sales/history', 'Sales::history');
});