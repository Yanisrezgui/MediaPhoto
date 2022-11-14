<?php

namespace App\Service;

use Doctrine\ORM\EntityManager;
use App\Domain\User;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

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


    public function signIn(string $email, string $password): bool
    {
        $req = $this->em->getRepository(\App\Domain\User::class)->findBy(['email' => $email]);
        $this->logger->info("UserService::get($email)");
        if ($req == null) {
            $this->logger->info("UserService::get($email) : user not found");
            return false;
        } else {
            if ($req[0]->checkPassword($password)) {
                $this->logger->info("UserService::get($email) : user found");
                return $req[0]->getId();

            } else {
                $this->logger->info("UserService::get($password) : wrong password");
                return false;
            }
        }
    }


    
}