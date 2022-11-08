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

  public function test(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {
    //$user = $this->userService->signUp('9@gmail.com','mdp','g');
    $repository=$this->em->getRepository(User::class);
    $user=$repository->findAll();
    return $this->view->render($response, 'hello.twig', [
      'users' => $user,
    ]);
    return $response;
  }
}