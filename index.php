    <?php

    require_once './autoloader.php';
    include 'generatedScript.php';


    use Cors\Cors;
    use DTO\RequestApiDTO;
    use Router\Router;

    set_error_handler([ErrorHandler::class, 'handleError']);
    set_exception_handler([ErrorHandler::class, 'handleException']);

    Cors::allowHeaders();

    $method = $_SERVER['REQUEST_METHOD'];
    $parts = explode("/", $_SERVER["REQUEST_URI"]);
    $endpoint = $parts[2] ?? null;
    $id = $parts[3] ?? null;
    $action = $parts[4] ?? null;

    $request = new RequestApiDTO($method, $endpoint, $id, $action);

    $router = new Router();
    $router->route($request);
