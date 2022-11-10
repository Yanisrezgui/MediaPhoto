<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\TwigMiddleware;

require __DIR__ . '/../vendor/autoload.php';

$container = require_once __DIR__ . '/../bootstrap.php';

AppFactory::setContainer($container);

$app = AppFactory::create();

$app->add(TwigMiddleware::createFromContainer($app));

$app->get('/', \App\Controller\HomeController::class . ':home');
$app->get('/new-gallery', \App\Controller\HomeController::class . ':createGalleryPage');
$app->post('/new-gallery/create', \App\Controller\HomeController::class . ':createGalleryFunction');

$app->get('/images', \App\Controller\ImagesController::class . ':images');
$app->get('/description', \App\Controller\ImagesController::class . ':description');
$app->get('/uploadImage', \App\Controller\ImagesController::class . ':uploadImage');

$app->get('/signUp', \App\Controller\UserController::class . ':promptInscription');
$app->post('/signUp/createUser', \App\Controller\UserController::class . ':signUp');
$app->get('/signIn', \App\Controller\ProfileController::class . ':signIn');
$app->get('/logout', \App\Controller\ProfileController::class . ':logout');

$app->get('/users', \App\UserController::class . ':test');

$app->run();