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

        $currentDate = date('Y-m-d');
        $date = new DateTimeImmutable($currentDate);
        
        $this->em->persist(new Image("landscape", "art", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam bibendum lorem tincidunt vestibulum eleifend. Vestibulum vehicula interdum risus, ut accumsan risus tristique vel. Interdum et malesuada fames ac ante ipsum primis in faucibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Quisque vitae odio in quam finibus suscipit nec feugiat mi. Etiam egestas cursus nibh, tristique consequat turpis imperdiet in. Vivamus vulputate mattis dui a congue. Aenean at quam a nibh egestas semper sit amet ut lacus. Vivamus faucibus quam sed nibh egestas, a gravida arcu molestie. Sed pharetra gravida massa id molestie. Vestibulum justo orci, convallis sed massa non, laoreet ultrices nulla. Aliquam vitae magna sed urna aliquam aliquet. ", $img, $date));
        $this->em->flush();

        return $response
            ->withHeader('Location', '/uploadImage')
            ->withStatus(302);

    }
}
