<?php
namespace App\Controller;

use App\Domain\Image;
use App\Domain\Galerie;
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

    return $this->view->render($response, 'gallery/gallery.html.twig', [
      'galleries' => $galleries,
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
    $repository = $this->em->getRepository(\App\Domain\User::class); 

    // $currentUser = $repository->findOneBy([
    //   'id' => $_SESSION["id_util"]
    // ]);
    
    // $login = $this->userService->signIn($args["email"], $args["password"]);
    // if($login) {
    //   $_SESSION["email"] = $args["email"];
    //   $user = $repository->findOneBy([
    //       'email' => $args["email"]
    //   ]);
      if (isset($args["titre"]) && isset($args["keywords"])) {
        if ($args['radio-accessibility'] == 'public') { 
          $accessibility = true;
        } else {
          $accessibility = false;
        }

        $galerie = new Galerie($accessibility,$args["titre"],$args["description"],$args["keywords"]);
        // $galerie->setUser($currentUser);
        // $galerie->addUserAcces($user1);
        $this->em->persist($galerie);
        $this->em->flush();
      }
    // }

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

}
