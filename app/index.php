<?php


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require __DIR__ . '/vendor/autoload.php';
require 'models/Item.php';

// Create Twig
$twig = Twig::create('templates', ['cache' => false]);


$app = AppFactory::create();

// Add Twig-View Middleware
$app->add(TwigMiddleware::create($app, $twig));

$app->get('/', function (Request $request, Response $response, $args) {

    $items = Item::findAll();
    

    $view = Twig::fromRequest($request);
    return $view->render($response, 'home.html', [
        'items' => $items
    ]);
});

$app->get('/item/{id}', function (Request $request, Response $response, $args) {
    $id = $args['id'];
    $item = Item::findById($id);
    $view = Twig::fromRequest($request);
    return $view->render($response, 'item.html', [
        'item' => $item
    ]);
});

// new item
$app->get('/new', function (Request $request, Response $response, $args) {
    $view = Twig::fromRequest($request);
    return $view->render($response, 'item.html');
});

$app->get('/items', function (Request $request, Response $response, $args) {
    $items = Item::findAll();
    $view = Twig::fromRequest($request);
    return $view->render($response, 'items.html', [
        'items' => $items
    ]);
});

// checkout route

$app->get('/item/{id}/checkout', function (Request $request, Response $response, $args) {
    $id = $args['id'];
    $item = Item::findById($id);
    $view = Twig::fromRequest($request);
    return $view->render($response, 'checkout.html', [
        'item' => $item
    ]);
});

$app->run();
