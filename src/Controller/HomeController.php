<?php
namespace App\Controller;

use App\Domain\Galerie;
use App\Domain\User;
use App\Service\GalleryService;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use App\Service\UserService;

class HomeController
{
  private $view;
  private $em;

  public function __construct(Twig $view, UserService $userService, GalleryService $galleryService, EntityManager $em)
  {
    $this->view = $view;
    $this->em = $em;
    $this->userService = $userService;
    $this->galleryService = $galleryService;
  }

  public function home(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {   
    $galleries = $this->galleryService->getAllGalleries();
    $query = $this->em->createQueryBuilder();
    $query->select('i')
      ->from('App\Domain\Image', 'i')
      ->groupBy('i.galerie');

    $images = $query->getQuery()->getResult();

    return $this->view->render($response, 'gallery/gallery.html.twig', [
      'galleries' => $galleries,
      'images' => $images,
      'connecter' => isset($_SESSION['connecter']),
      'email' => $_SESSION["email"] ?? "",
      'id_util' => $_SESSION["id_util"] ?? "",
      'pseudo' => $_SESSION["pseudo"] ?? "",
    ]);
  }

  public function createGalleryPage(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {
    return $this->view->render($response, 'gallery/createGallery.html.twig',[
      'connecter' => isset($_SESSION['connecter']),
      'email' => $_SESSION["email"] ?? "",
      'id_util' => $_SESSION["id_util"] ?? "",
      'pseudo' => $_SESSION["pseudo"] ?? "",
    ]);
  }

  public function createGalleryFunction(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {
    $args = $request->getParsedBody();

    $currentUser = $this->userService->getCurrentUser();

      if (isset($args["titre"]) && isset($args["keywords"])) {
        if ($args['radio-accessibility'] == 'public') { 
          $accessibility = true;
        } else {
          $accessibility = false;
        }

        $galerie = new Galerie($accessibility,$args["titre"],$args["description"],$args["keywords"]);
        $galerie->setUser($currentUser);
        // $galerie->addUserAcces($user1);
        $this->em->persist($galerie);
        $this->em->flush();
      }

    return $response
      ->withHeader('Location', '/')
      ->withStatus(302);
  }

  public function sortGallery(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {
    $args = $request->getParsedBody();

    $repository = $this->em->getRepository(Galerie::class); 
    $galleries = $repository->findBy([
      'motcle' => $args['search-bar'],
    ]);

    return $this->view->render($response, 'gallery/gallery.html.twig', [
      'galleries' => $galleries,
      'motCle' => $args['search-bar'],
    ]);
  }
  
  public function editGalleryPage(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {
    $idGallery = $args['idGallery'];
    $repository = $this->em->getRepository(Galerie::class); 
    $gallery = $repository->findOneBy([
      'id' => $idGallery,
    ]);
    return $this->view->render($response, 'gallery/editGallery.html.twig',[
      'connecter' => isset($_SESSION['connecter']),
      'email' => $_SESSION["email"] ?? "",
      'id_util' => $_SESSION["id_util"] ?? "",
      'pseudo' => $_SESSION["pseudo"] ?? "",
      "gallery" => $gallery
  ]);
  }

  public function editGalleryFunction(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {
    $form = $request->getParsedBody();
    $idGallery = $args['idGallery'];
    
    $repository = $this->em->getRepository(Galerie::class); 
    $gallery = $repository->findOneBy([
      'id' => $idGallery,
    ]);

    if ($form['radio-accessibility'] == 'public') { 
      $accessibility = true;
    } else {
      $accessibility = false;
    }

    $gallery->setTitre($form["titre"]);
    $gallery->setDescription($form["description"]);
    $gallery->setMotCle($form["keywords"]);
    $gallery->setAcces($accessibility);

    $this->em->persist($gallery);
    $this->em->flush();

    return $response
      ->withHeader('Location', '/gallery/' . $idGallery)
      ->withStatus(302);
  }


  public function addUserGallery(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {
    $idGallery=$args['idGallery'];
    $arg = $request->getParsedBody();


    $galleryRepository = $this->em->getRepository(Galerie::class); 
    $gallery = $galleryRepository->findOneBy([
      'id' => $idGallery,
    ]);

    $user=$arg['addUser'];
    
    $userRepository = $this->em->getRepository(User::class); 
    $userAcces = $userRepository->findOneBy([
      'pseudo' => $user,
    ]);

  //$idUser=$userAcces->{'id'};

   $gallery->addUserAcces($userAcces);

   $this->em->persist($gallery);
   $this->em->flush();
    
   return $response
   ->withHeader('Location', '/gallery/'.$idGallery)
   ->withStatus(302);
  }

}