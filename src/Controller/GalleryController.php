<?php
namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class GalleryController
{
    private $view;

    public function __construct(Twig $view)
    {
        $this->view = $view;
    }

    public function gallery(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return $this->view->render($response, 'gallery/gallery.html.twig');
    }

    public function createGallery(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return $this->view->render($response, 'gallery/createGallery.html.twig');
    }
}
