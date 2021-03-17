<?php

/**
 * Routing
 */

$route->addRoute('GET', '/', 'Home@indexAction');
$route->addRoute('GET', '/users', 'Home@indexAction');
// {id} must be a number (\d+)
$route->addRoute('GET', '/user/{id:\d+}', 'Home@getUserId');
