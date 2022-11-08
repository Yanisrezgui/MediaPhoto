<?php

namespace App;

use Doctrine\ORM\EntityManager;
use App\Domain\Galerie;
use Psr\Log\LoggerInterface;

final class galerieService
{
    private EntityManager $em;

    public function __construct(EntityManager $em, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }
}   
?>