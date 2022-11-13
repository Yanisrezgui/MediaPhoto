<?php

namespace App\Service;

use App\Domain\Galerie;
use Doctrine\ORM\EntityManager;

final class GalleryService
{
    private EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getAllGalleries() {
        $repository = $this->em->getRepository(Galerie::class); 
        $galleries = $repository->findAll();

        return $galleries;
    }
}   
