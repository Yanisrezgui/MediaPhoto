<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\TwigMiddleware;
session_start();

require __DIR__ . '/../vendor/autoload.php';

$container = require_once __DIR__ . '/../bootstrap.php';

AppFactory::setContainer($container);

$app = AppFactory::create();

$app->add(TwigMiddleware::createFromContainer($app));

$app->get('/', \App\Controller\HomeController::class . ':home');
$app->get('/a-propos', \App\Controller\HomeController::class . ':propos');

$app->get('/gallery/{idGallery}', \App\Controller\ImagesController::class . ':images');
$app->get('/new-gallery', \App\Controller\HomeController::class . ':createGalleryPage');
$app->post('/new-gallery/create', \App\Controller\HomeController::class . ':createGalleryFunction');
$app->post('/sort-gallery', \App\Controller\HomeController::class . ':sortGallery');
$app->post('/addUserGallery/{idGallery}', \App\Controller\HomeController::class . ':addUserGallery');

$app->get('/edit-gallery/{idGallery}', \App\Controller\HomeController::class . ':editGalleryPage');
$app->post('/edit-gallery/edit/{idGallery}', \App\Controller\HomeController::class . ':editGalleryFunction');

$app->get('/image/{idImage}', \App\Controller\ImagesController::class . ':description');
$app->get('/uploadImage/{idGallery}', \App\Controller\ImagesController::class . ':view');
$app->post('/uploadImage/post/{idGallery}', \App\Controller\ImagesController::class . ':uploadImage');
$app->post('/sort-image', \App\Controller\ImagesController::class . ':sortImage');

$app->get('/signUp', \App\Controller\UserController::class . ':promptInscription');
$app->post('/signUp/createUser', \App\Controller\UserController::class . ':signUp');
$app->get('/signIn', \App\Controller\UserController::class . ':signInView');
$app->post('/signIn/signUser', \App\Controller\UserController::class . ':signIn');
$app->get('/logout', \App\Controller\UserController::class . ':logout');
$app->get('/mon-compte', \App\Controller\UserController::class . ':monCompte');
$app->get('/mon-compte/mes-galeries', \App\Controller\UserController::class . ':mesGaleries');

$app->get('/users', \App\UserController::class . ':test');

$app->run();