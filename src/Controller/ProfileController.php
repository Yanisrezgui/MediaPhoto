<?php
namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class ProfileController
{
    private $view;

    public function __construct(Twig $view)
    {
        $this->view = $view;
    }

    public function signIn(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return $this->view->render($response, 'profile/signIn.html.twig');
    }

    public function signUp(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return $this->view->render($response, 'profile/signUp.html.twig');
    }

    public function logout(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        session_start();
        session_destroy();
        return $this->view->render($response, 'gallery/gallery.html.twig');
    }
}