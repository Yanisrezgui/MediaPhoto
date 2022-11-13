<?php
namespace App\Controller;

use App\Domain\Image;
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

        $repositoryImage = $this->em->getRepository(Image::class);
        $images = $repositoryImage->findBy([
            'galerie' => $gallery
        ]);

        return $this->view->render($response, 'images/images.html.twig', [
            "gallery" => $gallery,
            "images" => $images,
            'connecter' => isset($_SESSION['connecter']),
            'email' => $_SESSION["email"] ?? "",
            'id_util' => $_SESSION["id_util"] ?? "",
            'pseudo' => $_SESSION["pseudo"] ?? "",
        ]);
    }

    public function description(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $idImage = $args['idImage'];

        $repository = $this->em->getRepository(Image::class);
        $image = $repository->findOneBy([
            'id_img' => $idImage
        ]);


        return $this->view->render($response, 'images/description.html.twig', [
            'image' => $image,
            'connecter' => isset($_SESSION['connecter']),
            'email' => $_SESSION["email"] ?? "",
            'id_util' => $_SESSION["id_util"] ?? "",
            'pseudo' => $_SESSION["pseudo"] ?? "",
        ]);
    }

    public function view(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $repository = $this->em->getRepository(Galerie::class); 
        $galleries = $repository->findAll();
        return $this->view->render($response, 'images/uploadImage.html.twig', [
            'galleries' => $galleries
        ]);
    }

    public function uploadImage(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $args = $request->getParsedBody();
        $repository = $this->em->getRepository(Galerie::class); 
        $gallerie = $repository->findOneBy([
        'id' => $args['galerie'],
        ]);

        $name = $_FILES['myfile']['name'];
        $type = $_FILES['myfile']['type'];
        $data = file_get_contents($_FILES['myfile']['tmp_name']);

        $image = new Image($args["keywords"],$args["titre"],$args["desc"],$name, $type, $data);
        $image->setGalerie($gallerie);
        $this->em->persist($image);
        $this->em->flush();

        return $response
            ->withHeader('Location', '/uploadImage')
            ->withStatus(302);
    }

    public function sortImage(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
    $args = $request->getParsedBody();

    $repository = $this->em->getRepository(Image::class); 
    $images = $repository->findBy([
      'motcle' => $args['search-bar'],
    ]);

    return $this->view->render($response, 'images/images.html.twig', [
      'images' => $images,
      'motCle' => $args['search-bar'],
    ]);
    }
}
