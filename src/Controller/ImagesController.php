<?php
namespace App\Controller;

use App\Domain\Galerie;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class ImagesController
{
    private $view;

    public function __construct(Twig $view, EntityManager $em)
    {
        $this->view = $view;
        $this->em = $em;
    }

    public function images(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $idGallery = $args['idGallery'];
        $repository = $this->em->getRepository(Galerie::class);
        $gallery = $repository->findOneBy([
            'id' => $idGallery
        ]);

        return $this->view->render($response, 'images/images.html.twig', [
            "gallery" => $gallery,
        ]);
    }

    public function description(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return $this->view->render($response, 'images/description.html.twig');
    }

    public function uploadImage(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return $this->view->render($response, 'images/uploadImage.html.twig');
    }
}
