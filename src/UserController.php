<?php
namespace App;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Doctrine\ORM\EntityManager;
use Slim\Views\Twig;
use App\Domain\User;

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

  public function afficheInscription(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {
    return $this->view->render($response, 'inscription.twig');
    return $response; 
  }

  public function inscription(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
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
            return $this->view->render($response, 'inscription.twig', [
              'erreurVerifMdp' => $erreurVerifMdp,
              'products' => $productMail
            ]);
        }
        else if ($args["pseudo"] == "") {
          $erreurPseudo = "Veuillez rentrer un pseudo";
          return $this->view->render($response, 'inscription.twig', [
            'erreurPseudo' => $erreurPseudo,
          ]);
        }
        else if ($args["password"] == "" ) {
          $erreurMdp = "Veuillez rentrer un mot de passe";
          return $this->view->render($response, 'inscription.twig', [
            'erreurMdp' => $erreurMdp,
          ]);
        }
        else if ($args["passwordVerif"] == "") {
          $erreurVerifMdp = "Veuillez confirmez votre mot de passe";
          return $this->view->render($response, 'inscription.twig', [
            'erreurVerifMdp' => $erreurVerifMdp
          ]);
        }
        else if ($args["mail"] == "") {
          $erreurMail = "Veuillez rentrer une adresse mail";
          return $this->view->render($response, 'inscription.twig', [
            'erreurMail' => $erreurMail,
          ]);
        }
        else if ($args["mail"] = $productMail) {
        $erreurMail = "L'adresse mail existe deja veuillez changer";
        return $this->view->render($response, 'inscription.twig', [
          'erreurMail' => $erreurMail,
        ]);
        }
        else if ($args["pseudo"] = $productPseudo) {
          $erreurPseudo = "Le pseudo existe deja veuillez changer";
          return $this->view->render($response, 'inscription.twig', [
            'erreurPseudo' => $erreurPseudo
          ]);
        }
        else if ($erreurPseudo = "" && $erreurMdp = "" && $erreurMail = "" && $erreurVerifMdp = "") {
          $this->userService->signup($args["mail"], $args["password"], $args["pseudo"]); 
        }
}
    return $response
            ->withHeader('Location', '/')
            ->withStatus(302);
  }
}