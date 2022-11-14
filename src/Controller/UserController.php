<?php
namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Doctrine\ORM\EntityManager;
use Slim\Views\Twig;
use App\Domain\User;
use App\Domain\Galerie;
use App\Service\UserService;

class UserController
{
  private $view;
  private $em;

  public function __construct(Twig $view, UserService $userService, EntityManager $em)
  {
    $this->view = $view;
    $this->userService = $userService;
    $this->em=$em;
  }

  public function promptInscription(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {
    return $this->view->render($response, '/profile/signUp.html.twig');
    return $response; 
  }

  public function signUp(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {
    $args = $request->getParsedBody();
    $repository = $this->em->getRepository(User::class);
    $productPseudo = $repository->findOneBy([
      'pseudo' => $args["pseudo"]
    ]);
    $productMail = $repository->findOneBy([
      'email' => $args["mail"]
    ]);
    
    if (isset($args["mail"]) && isset($args["password"]) && isset($args["pseudo"])) {
      if ($args["password"] != $args["passwordVerif"]) {
        $erreurVerifMdp = "Les mots de passe ne correspondent pas";
        return $this->view->render($response, '/profile/signUp.html.twig', [
          'erreurVerifMdp' => $erreurVerifMdp,
          'products' => $productMail
        ]);
      }
      else if ($args["pseudo"] == "") {
        $erreurPseudo = "Veuillez rentrer un pseudo";
        return $this->view->render($response, '/profile/signUp.html.twig', [
          'erreurPseudo' => $erreurPseudo,
        ]);
      }
      else if ($args["password"] == "" ) {
        $erreurMdp = "Veuillez rentrer un mot de passe";
        return $this->view->render($response, '/profile/signUp.html.twig', [
          'erreurMdp' => $erreurMdp,
        ]);
      }
      else if ($args["passwordVerif"] == "") {
        $erreurVerifMdp = "Veuillez confirmez votre mot de passe";
        return $this->view->render($response, '/profile/signUp.html.twig', [
          'erreurVerifMdp' => $erreurVerifMdp
        ]);
      }
      else if ($args["mail"] == "") {
        $erreurMail = "Veuillez rentrer une adresse mail";
        return $this->view->render($response, '/profile/signUp.html.twig', [
          'erreurMail' => $erreurMail,
        ]);
      }
      else if ($args["mail"] == $productMail) {
      $erreurMail = "L'adresse mail existe deja veuillez changer";
      return $this->view->render($response, '/profile/signUp.html.twig', [
        'erreurMail' => $erreurMail,
      ]);
      }
      else if ($args["pseudo"] == $productPseudo) {
        $erreurPseudo = "Le pseudo existe deja veuillez changer";
        return $this->view->render($response, '/profile/signUp.html.twig', [
          'erreurPseudo' => $erreurPseudo
        ]);
      }
      else  {
        $this->userService->signUp($args["mail"], $args["password"], $args["pseudo"]); 
      }
    }
    return $response
      ->withHeader('Location', '/signIn')
      ->withStatus(302);
  }

  public function signIn(ServerRequestInterface $request, ResponseInterface $response) : ResponseInterface
  {
      $args = $request->getParsedBody();
      $errorLogin = "";
      if (isset($args["email"]) && isset($args["password"])) {
          $login = $this->userService->signIn($args["email"], $args["password"]);
          if ($login === false) {
            $errorLogin = "Mauvais email ou mot de passe";
            return $this->view->render($response, 'profile/signIn.html.twig', [
              'errorLogin' => $errorLogin
            ]);
          } else {
              $repository = $this->em->getRepository(\App\Domain\User::class); 
            
              $_SESSION["connecter"] = $login;
              $_SESSION["email"] = $args["email"];
              $user = $repository->findOneBy([
                'email' => $args["email"]
              ]);
            
              $_SESSION['id_util']= $user->{'id'};
              $_SESSION['pseudo']= $user->{'pseudo'};
          }
      }

      return $response
        ->withHeader('Location', '/')
        ->withStatus(302);
  }

  public function logout(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {
      session_destroy();
      return $response
        ->withHeader('Location', '/')
        ->withStatus(302);
  }

  public function signInView(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {
      return $this->view->render($response, 'profile/signIn.html.twig');
  }

  public function monCompte(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {
    return $this->view->render($response, '/profile/moncompte.html.twig', [
      'connecter' => isset($_SESSION['connecter']),
      'email' => $_SESSION["email"] ?? "",
      'id_util' => $_SESSION["id_util"] ?? "",
      'pseudo' => $_SESSION["pseudo"] ?? "",
    ]);
  }

  public function mesGaleries(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {

    $repositoryUser = $this->em->getRepository(User::class); 
    $repositoryGalerie = $this->em->getRepository(Galerie::class);

    $currentUser = $repositoryUser->findOneBy([
      'id' => $_SESSION["id_util"]
    ]);

    $galleries = $repositoryGalerie->findBy([
      'user' => $currentUser
    ]);


    return $this->view->render($response, '/profile/mesgaleries.html.twig', [
      'connecter' => isset($_SESSION['connecter']),
      'email' => $_SESSION["email"] ?? "",
      'id_util' => $_SESSION["id_util"] ?? "",
      'pseudo' => $_SESSION["pseudo"] ?? "",
      'galleries' => $galleries
    ]);
  }

}