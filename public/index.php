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
$app->get('/createGallery', \App\Controller\GalleryController::class . ':createGallery');
$app->get('/gallery', \App\Controller\GalleryController::class . ':gallery');
$app->get('/images', \App\Controller\ImagesController::class . ':images');
$app->get('/description', \App\Controller\ImagesController::class . ':description');
$app->get('/uploadImage', \App\Controller\ImagesController::class . ':uploadImage');
$app->get('/signIn', \App\Controller\ProfileController::class . ':signIn');
$app->get('/signUp', \App\Controller\ProfileController::class . ':signUp');
$app->get('/logout', \App\Controller\ProfileController::class . ':logout');
$app->get('/users', \App\UserController::class . ':test');

$app->run();