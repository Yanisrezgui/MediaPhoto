<?php
namespace App\Controller;

use App\Domain\Image;
use Doctrine\DBAL\Types\BlobType;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use Slim\Views\Twig;

class ImagesController
{
    private $view;

    public function __construct(Twig $view)
    {
        $this->view = $view;
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
        $directory = '/uploads';
        $uploadedFiles = $request->getUploadedFiles();

        $uploadedFile = $uploadedFiles["myfile"];
        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
            $basename = bin2hex(random_bytes(8));
            $filename = sprintf('%s.%0.8s', $basename, $extension);

            $blob = file_get_contents($filename);

            $this->em->persist(new Image("chat", "titre", "description", $filename, $extension, $blob));
            $this->em->flush();

            $response->getBody()->write('Uploaded: ' . $filename . '<br/>');
        }
        // $myfile = $request->getUploadedFiles();

        // $name = $_FILES[$myfile]['name'];
        // $type = $_FILES[$myfile]['type'];
        // $data = $_FILES[$myfile]['tmp_name'];

        // var_dump($data);

        // $this->em->persist(new Image("chat", "titre", "description", $name, $type, $data));
        // $this->em->flush();

        return $response
            ->withHeader('Location', '/uploadImage')
            ->withStatus(302);
    }
}
