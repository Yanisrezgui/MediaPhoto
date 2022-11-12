<?php
namespace App\Controller;

use App\Domain\Image;
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
        $repository = $this->em->getRepository(Image::class);
        $images = $repository->findAll();

        return $this->view->render($response, 'images/images.html.twig', [
            "images" => $images
        ]);
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
        $name = $_FILES['myfile']['name'];
        $type = $_FILES['myfile']['type'];
        $data = file_get_contents($_FILES['myfile']['tmp_name']);
   
        $this->em->persist(new Image("motcle", "titre", "desc", $name, $type, $data));
        $this->em->flush();

        return $response
            ->withHeader('Location', '/uploadImage')
            ->withStatus(302);
    }
}
