<?php
namespace App\Controller;

use App\Service\GalleryService;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class HomeController
{
  private $view;
  private $em;

  public function __construct(Twig $view, EntityManager $em)
  {
    $this->view = $view;
    $this->em = $em;
  }

  public function home(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {
    return $this->view->render($response, 'gallery/gallery.html.twig');
  }

  public function createGalleryPage(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {
    return $this->view->render($response, 'gallery/createGallery.html.twig');
  }

}
