<?php

namespace App\Service;

use App\Domain\Image;
use Doctrine\ORM\EntityManager;

final class GalleryService
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function insertImage()
    {
        
        $name = $_FILES[$myfile]['name'];
        $type = $_FILES[$myfile]['type'];
        $data = file_get_contents($_FILES[$myfile]['tmp_name']);

        $this->em->persist(new Image("chat", "titre", "description", $name, $type, $data));
        $this->em->flush();
    }
}   
