<?php

namespace App\Service;

use Doctrine\ORM\EntityManager;
use App\Domain\User;
use Psr\Log\LoggerInterface;


final class UserService
{
    private EntityManager $em;

    public function __construct(EntityManager $em,LoggerInterface $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }

    public function signUp(string $email,string $password, string $pseudo): User
    {
        $newUser = new User($email,$password,$pseudo);
        $this->em->persist($newUser);
        $this->em->flush();

        return $newUser;
    }
}