<?php

namespace App\Domain;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\OneToMany;


#[Entity, Table(name: 'Utilisateur')]
final class User
{
    #[Id, Column(name:'id_util',type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[Column(name:'email',type: 'string', unique: true, nullable: false)]
    private string $email;

    #[Column(name: 'password', type: 'string', nullable: false)]
    private string $password;

    #[Column(name: 'pseudo', type: 'string',unique:true, nullable: false)]
    private string $pseudo;

    #[OneToMany(targetEntity: Galerie::class, mappedBy:'user')]

    public function __construct(string $email,string $password, string $pseudo)
    {
        $this->email = $email;
        $this->password= $password;
        $this->pseudo= $pseudo;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function getPseudo(): string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo)
    {
        $this->pseudo = $pseudo;
    }
}