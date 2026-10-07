<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Pages::landing');
$routes->get('about', 'Pages::about');
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    // Customer Accounts
    $routes->get('customers', 'Customers::index');
    $routes->get('customers/new', 'Customers::new');
    $routes->post('customers', 'Customers::create');
    $routes->get('customers/(:num)/edit', 'Customers::edit/$1');
    $routes->post('customers/(:num)', 'Customers::update/$1');

    // User Accounts
    $routes->get('users', 'Users::index');
    $routes->get('users/new', 'Users::new');
    $routes->post('users', 'Users::create');
    $routes->get('users/(:num)/edit', 'Users::edit/$1');
    $routes->post('users/(:num)', 'Users::update/$1');

    $routes->get('account/password', 'Auth::changePasswordForm');
    $routes->post('account/password', 'Auth::changePassword');
});
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attempt');
$routes->post('logout', 'Auth::logout', ['filter' => 'auth']);
$routes->setAutoRoute(false);
$routes->get('account/password', 'Auth::changePasswordForm');
$routes->post('account/password', 'Auth::changePassword');
