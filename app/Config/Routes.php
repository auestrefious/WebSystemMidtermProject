<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attempt');
$routes->get('dashboard', 'Auth::dashboard');
$routes->post('logout', 'Auth::logout');
$routes->get('customers', 'Customers::index');
$routes->get('customers/new', 'Customers::add');
$routes->post('customers', 'Customers::store');
$routes->get('customers/(:num)/edit', 'Customers::edit/$1');
$routes->post('customers/(:num)/update', 'Customers::update/$1');
$routes->post('customers/(:num)/delete', 'Customers::delete/$1');
$routes->get('products', 'Products::index');
$routes->get('products/new', 'Products::add');
$routes->post('products', 'Products::store');
$routes->get('products/(:num)/edit', 'Products::edit/$1');
$routes->post('products/(:num)/update', 'Products::update/$1');
$routes->post('products/(:num)/archive', 'Products::archive/$1');