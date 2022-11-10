<?php

namespace App\Domain;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\InverseJoinColumn;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;

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
    private $galeries;

    
    
    public function __construct(string $email,string $password, string $pseudo)
    {
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        $this->pseudo= $pseudo;
        $this->galeries= new ArrayCollection();
        $this->galerie_acces= new ArrayCollection();

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

    public function getGaleries(): Collection
    {
        return $this->galeries;
    }

    public function checkPassword($pass) : bool {
        return password_verify($pass, $this->password);
    }

    
}