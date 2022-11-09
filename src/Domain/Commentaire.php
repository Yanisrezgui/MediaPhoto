<?php

namespace App\Domain;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;


#[Entity, Table(name: 'Commentaires')]
final class Commentaire
{
    #[Id, Column(name:'id_com',type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[Column(name:'commentaires',type: 'string', unique: true, nullable: false)]
    private string $commentaire;

    #[ManyToOne(targetEntity: Image::class, inversedBy: 'commentaires')]
    private $image;

    public function __construct(string $commentaire)
    {
        $this->commentaire=$commentaire;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCom(){
        return $this->commentaire;
    }

    public function getimage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        $this->image = $image;
        return $this;
    }
    
}