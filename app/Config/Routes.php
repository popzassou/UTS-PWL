<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index', ['filter' => 'auth']);

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::login');
$routes->post('logout', 'AuthController::logout');

$routes->get('/admin', 'Home::adminDashboard', ['filter' => 'auth']);
$routes->get('/user', 'Home::userDashboard', ['filter' => 'auth']);

//CRUD user
$routes->get('/users', 'Home::users', ['filter' => 'auth']);        
$routes->get('/users/create', 'Home::create', ['filter' => 'auth']); 
$routes->post('/users/store', 'Home::store');                        
$routes->get('/users/edit/(:any)', 'Home::edit/$1');                 
$routes->post('/users/update/(:any)', 'Home::update/$1');            // Update user berdasarkan username
$routes->get('/users/delete/(:any)', 'Home::delete/$1');             // Hapus user berdasarkan username
$routes->get('/buku', 'Home::buku', ['filter' => 'auth']);

//CRUD Buku
$routes->get('/buku/create', 'Home::createBuku', ['filter' => 'auth']);
$routes->post('/buku/store', 'Home::storeBuku', ['filter' => 'auth']);
$routes->get('/buku/edit/(:any)', 'Home::editBuku/$1', ['filter' => 'auth']);
$routes->post('/buku/update/(:any)', 'Home::updateBuku/$1', ['filter' => 'auth']);
$routes->get('/buku/delete/(:any)', 'Home::deleteBuku/$1', ['filter' => 'auth']);

$routes->get('/katalog', 'Home::katalog', ['filter' => 'auth']);
$routes->get('/buku/pinjam/(:any)', 'Home::pinjamBuku/$1', ['filter' => 'auth']);