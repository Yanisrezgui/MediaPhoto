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

    public function getGalleryPrivate(): array
    {
        $galleryPrivate[] = "";
        $req = $this->em->getRepository(\App\Domain\Galerie::class)->findBy(['acces' => 0]);
        foreach ($req as $gallery) {
            $users = $gallery->getUserAcces()->toArray();
            foreach ($users as $user) {
                if ($user->getId() === $_SESSION['id_util']|| $gallery->getUser()->getId() === $_SESSION['id_util'] ) {
                    array_push($galleryPrivate, $gallery);
                }
            }
        }
        return $galleryPrivate;
    }


    
}   