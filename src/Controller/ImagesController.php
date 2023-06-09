<?php
namespace App\Controller;

use App\Domain\Image;
use App\Domain\Galerie;
use App\Service\UserService;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class ImagesController
{
    private $view;

    public function __construct(Twig $view,UserService $userService, EntityManager $em)
    {
        $this->view = $view;
        $this->em = $em;
        $this->userService = $userService;
    }

    public function images(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $idGallery = $args['idGallery'];
        $repository = $this->em->getRepository(Galerie::class);
        $gallery = $repository->findOneBy([
            'id' => $idGallery
        ]);

        $creatorUser=$gallery->{'user'}->{'id'};

        $repositoryImage = $this->em->getRepository(Image::class);
        $images = $repositoryImage->findBy([
            'galerie' => $gallery
        ]);

        return $this->view->render($response, 'images/images.html.twig', [
            "idGallery" => $idGallery,
            "gallery" => $gallery,
            "creatorUser"=>$creatorUser,
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
        $idGallery = $args['idGallery'];
        $currentUser = $this->userService->getCurrentUser();

        $repository = $this->em->getRepository(Galerie::class); 
        $galleries = $repository->findBy([
            'user' => $currentUser,
        ]);
        return $this->view->render($response, 'images/uploadImage.html.twig', [
            'idGallery' => $idGallery,
            'galleries' => $galleries,
            'connecter' => isset($_SESSION['connecter']),
            'email' => $_SESSION["email"] ?? "",
            'id_util' => $_SESSION["id_util"] ?? "",
            'pseudo' => $_SESSION["pseudo"] ?? "",
        ]);
    }

    public function uploadImage(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $idGallery = $args['idGallery'];
        $param = $request->getParsedBody();
        $repository = $this->em->getRepository(Galerie::class); 
        $gallerie = $repository->findOneBy([
            'id' => $idGallery,
        ]);

        $name = $_FILES['myfile']['name'];
        $type = $_FILES['myfile']['type'];
        $data = file_get_contents($_FILES['myfile']['tmp_name']);

        $image = new Image($param["keywords"],$param["titre"],$param["desc"],$name, $type, $data);
        $image->setGalerie($gallerie);
        $this->em->persist($image);
        $this->em->flush();

        $imgRepository = $this->em->getRepository(Image::class); 
        $imageReq = $imgRepository->findOneBy(
            array(),
            array('id_img' => 'DESC')
        );

        $idImg = $imageReq->getId_img();
        
        return $response
            ->withHeader('Location', '/image/' . $idImg)
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