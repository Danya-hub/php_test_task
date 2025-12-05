<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', '\App\Controllers\HomeController::index');

$routes->post('/ajax/sendWords', '\App\Controllers\Ajax\FormController::sendWords');
