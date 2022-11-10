<?php

namespace App\Service;

use Doctrine\ORM\EntityManager;

final class GalleryService
{
    private EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function newGallery() {
        return true;
    }
}   
