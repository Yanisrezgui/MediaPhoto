<?php

namespace App;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Doctrine\ORM\EntityManager;
use Slim\Views\Twig;
use App\Domain\Galerie;

class GalerieController{
    private $view;
    private $em;

    public function __construct(Twig $view, GalerieService $galerieService, EntityManager $em)
  {
    $this->view = $view;
    $this->galerieService = $galerieService;
    $this->em=$em;
  }

  public function affichForm(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {   
    return $this->view->render($response, 'Galerie.twig');
  }
}
