<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Client\ClientHomeController::index');

// Override Register Shield
$routes->get('register', 'RegisterController::index');
$routes->post('register', 'RegisterController::registerAction');

// Service Auth Shield (Login, Register, Logout routes)
service('auth')->routes($routes);

// Admin Area - Protected (Hanya bisa diakses oleh grup 'admin')
$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'group:admin'], function($routes) {
    $routes->get('/', 'AdminDashboardController::index');

    // CRUD Tingkat Risiko
    $routes->get('risk-levels/print', 'AdminRiskLevelController::printPDF');
    $routes->get('risk-levels/delete/(:num)', 'AdminRiskLevelController::delete/$1');
    $routes->presenter('risk-levels', ['controller' => 'AdminRiskLevelController']);

    // CRUD Faktor Risiko
    $routes->get('risk-factors/print', 'AdminRiskFactorController::printPDF');
    $routes->get('risk-factors/delete/(:num)', 'AdminRiskFactorController::delete/$1');
    $routes->presenter('risk-factors', ['controller' => 'AdminRiskFactorController']);

    // CRUD Aturan
    $routes->get('rules/print', 'AdminRuleController::printPDF');
    $routes->get('rules/delete/(:num)', 'AdminRuleController::delete/$1');
    $routes->presenter('rules', ['controller' => 'AdminRuleController']);

    // Manajemen Pengguna
    $routes->group('users', function($routes) {
        $routes->get('/', 'AdminUserController::index');
        $routes->get('new', 'AdminUserController::new');
        $routes->post('create', 'AdminUserController::create');
        $routes->get('edit/(:num)', 'AdminUserController::edit/$1');
        $routes->post('update/(:num)', 'AdminUserController::update/$1');
        $routes->get('delete/(:num)', 'AdminUserController::delete/$1');
    });

    // Riwayat
    $routes->get('history/print', 'AdminHistoryController::printPDF');
    $routes->get('history/detail/(:num)', 'AdminHistoryController::detail/$1');
    $routes->get('history/pdf/(:num)/(:any)', 'AdminHistoryController::pdf/$1/$2');

    $routes->get('history/delete/(:num)', 'AdminHistoryController::delete/$1');
    $routes->get('history', 'AdminHistoryController::index');
});

// Client Area (Routes Umum)
$routes->group('client', ['namespace' => 'App\Controllers\Client'], function($routes) {
    // Di sini bisa ditambahkan route lain yang memang spesifik harus diawali /client/
});

// Skrining (Akses langsung via /screening)
$routes->group('screening', ['namespace' => 'App\Controllers\Client'], function($routes) {
    $routes->get('/', 'ClientScreeningController::index');
    $routes->post('result', 'ClientScreeningController::result');
});

// Profil Pengguna (Akses langsung via /profile)
$routes->group('profile', ['namespace' => 'App\Controllers\Client'], function($routes) {
    $routes->get('/', 'ClientProfileController::index');
    $routes->post('update', 'ClientProfileController::update');
});

// Detail Riwayat (Akses langsung via /detail)
$routes->get('detail/(:num)', 'Client\ClientProfileController::detail/$1');
$routes->get('detail/pdf/(:num)/(:any)', 'Client\ClientProfileController::pdf/$1/$2');

