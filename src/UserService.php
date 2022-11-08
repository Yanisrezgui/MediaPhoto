<?php

namespace App;

use Doctrine\ORM\EntityManager;
use App\Domain\User;

final class UserService
{
    private EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function signUp(string $email,string $password, string $pseudo): User
    {
        $newUser = new User($email,$password,$pseudo);


        $this->em->persist($newUser);
        $this->em->flush();

        return $newUser;
    }
}