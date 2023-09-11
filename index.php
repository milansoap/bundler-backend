<?php

use Router\Cors;
use Router\ErrorHandler;
use Router\Router; // Import Router instead of Handler
use DTO\RequestApiDTO; // Make sure this is the correct namespace

set_error_handler([ErrorHandler::class, 'handleError']);
set_exception_handler([ErrorHandler::class, 'handleException']);

Cors::allowHeaders();

$method = $_SERVER['REQUEST_METHOD'];
$parts = explode("/", $_SERVER["REQUEST_URI"]);
$endpoint = $parts[2] ?? null;
$id = $parts[3] ?? null;
$action = $parts[4] ?? null;

$request = new RequestApiDTO($method, $endpoint, $id, $action); // Make sure the class name matches

$router = new Router(); // Use Router instead of Handler
$router->route($request); // Call the route method of Router
