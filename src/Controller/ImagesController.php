<?php
namespace App\Controller;

use App\Domain\Image;
use DateTimeImmutable;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class ImagesController
{
    private $view;
    private $blob;

    public function __construct(Twig $view, EntityManager $em)
    {
        $this->view = $view;
        $this->em = $em;
    }

    public function images(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return $this->view->render($response, 'images/images.html.twig');
    }

    public function description(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return $this->view->render($response, 'images/description.html.twig');
    }

    public function view(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return $this->view->render($response, 'images/uploadImage.html.twig');
    }

    public function uploadImage(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $name = $request->getParsedBody();
        $img = basename($_FILES['myfile']['name']);
        move_uploaded_file($_FILES['myfile']['tmp_name'], APP_ROOT . '/public/img/upload/'.$img);
   
        $this->em->persist(new Image("motcle", "titre", "desc", $img));
        $this->em->flush();

        return $response
            ->withHeader('Location', '/uploadImage')
            ->withStatus(302);

    }
}