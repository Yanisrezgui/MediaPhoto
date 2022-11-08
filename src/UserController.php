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

  public function affichForm(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {
    //$user = $this->userService->signUp('9@gmail.com','mdp','g');
    /* $repository=$this->em->getRepository(User::class);
    $user=$repository->findAll();
    return $this->view->render($response, 'inscription.twig', [
      'users' => $user,
    ]);
    return $response; */

    return $this->view->render($response, 'inscription.twig');
    return $response; 
  }

  public function inscription(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {

    $mail = $request -> getParsedBody()['mail'];
    $password = $request -> getParsedBody()['password'];
    $pseudo = $request -> getParsedBody()['pseudo'];
    $passwordverif = $request -> getParsedBody()['passwordVerif'];

    $mail=trim($mail);
    $password=trim($password);
    $pseudo=trim($pseudo);
    $passwordverif=trim($passwordverif);

    
    if( ($mail=='')  || ($password=='') || ($pseudo=='') || ($password!=$passwordverif))
    {
      return $response
      ->withHeader('Location', '/testhjzshdugdfgy')
      ->withStatus(302);
    }else{
      $this->userService->signUp($mail,$password,$pseudo);
    }


    

    return $response
            ->withHeader('Location', '/')
            ->withStatus(302);
  }
}