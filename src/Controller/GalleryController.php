<?php
namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use App\Service\GalleryService;

class GalleryController
{
    private $view;
    private $em;

    public function __construct(Twig $view ,GalleryService $galleryService, EntityManager $em)
    {
        $this->view = $view;
        $this->galleryService = $galleryService;
        $this->em = $em;
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
