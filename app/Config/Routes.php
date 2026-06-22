<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/login','Auth::login');
$routes->get('/register','Auth::register');
$routes->post('/register','Auth::prosesRegister');
$routes->post('/login','Auth::prosesLogin');

// Route dgn filter auth (hrs login)
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Dashboard::index');
    $routes->get('/dashboard', 'Dashboard::index');
    $routes->get('/kategori', 'Kategori::index');
    $routes->get('/logout', 'Auth::logout');
    $routes->get('/kategori/toggle/(:num)', 'Kategori::toggle/$1');
    $routes->get('/kategori/edit/(:num)', 'Kategori::edit/$1');
    $routes->post('/kategori/update/(:num)', 'Kategori::update/$1');
    $routes->get('/transaksi', 'Transaksi::index');
    $routes->post('/transaksi/simpan', 'Transaksi::simpan');
    $routes->get('/transaksi/hapus/(:num)', 'Transaksi::hapus/$1');
    $routes->get('/transaksi/edit/(:num)', 'Transaksi::edit/$1');
    $routes->post('/transaksi/update/(:num)', 'Transaksi::update/$1');
    $routes->get('/rekap', 'Rekap::index');
    $routes->get('/target', 'Target::index');
    $routes->post('/target/simpan', 'Target::simpan');
    $routes->get('/target/edit/(:num)', 'Target::edit/$1');
    $routes->post('/target/update/(:num)', 'Target::update/$1'); 
    $routes->get('/target/hapus/(:num)', 'Target::hapus/$1');
    $routes->get('/target/goals', 'Target::getGoals');
    // Tambahkan route lain yang memerlukan autentikasi di sini
});
?>